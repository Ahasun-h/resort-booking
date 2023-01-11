<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\AdminNotifyJob;
use App\Jobs\ClientInvoiceJob;
use App\Models\Booking;
use App\Models\Resort;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\Storage;


class ResortBookingController extends Controller
{
    /**
     * Get resort data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
       $resorts = Resort::with('resortImage')->get();
        $responce = [
            'success' => true,
            'data' => $resorts,
            'message' => "Resorts data get successfully"
        ];
       return response()->json($responce,200);
    }

    public function show($id){
        $resort = Resort::where('id',$id)->with('resortImage')->first();
        $responce = [
            'success' => true,
            'data' => $resort,
            'message' => "Resort data get successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Booking Process
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function booking(Request $request, $id){
        $request->validate([
            'email'             => 'required|email',
            'contact_number'    => 'required',
            'booking_date'      => 'required|date',
            'number_days'       => 'required',
        ]);

        $bookingDate = Carbon::createFromFormat('Y-m-d', $request->booking_date)->format('Y-m-d');

        // End Date
        $date = Carbon::createFromFormat('Y-m-d', $request->booking_date)->format('d-m-Y');
        $checkOutDate = Carbon::parse($date)->addDays($request->number_days)->format('Y-m-d');

        $checkin = $request->booking_date;
        $checkout = $checkOutDate;

         $result = Booking::where('resort_id', $id)
            ->where(function($query) use ($checkin, $checkout) {
                $query->where(function($query) use ($checkin, $checkout) {
                    $query->where('booking_date', '<', $checkout)
                        ->where('check_out_date', '>', $checkin);
                })->orWhere(function($query) use ($checkin, $checkout) {
                    $query->where('booking_date', '>=', $checkin)
                        ->where('check_out_date', '<=', $checkout);
                });
            })
            ->first();

         if($result){
             $responce = [
                 'success' => False,
                 'message' => "Sorry, Resort is already booked!"
             ];

             return response()->json($responce,200);
         }
         else{
             //
             $resort = Resort::findOrFail($id);
             $totalPrice = $resort->price_per_night * $request->number_days;

             $booking = new Booking();
             $booking->resort_id = $id;
             $booking->email = $request->email;
             $booking->contact_number = $request->contact_number;
             $booking->booking_date = Carbon::createFromFormat('Y-m-d', $request->booking_date)->format('Y-m-d');
             $booking->check_out_date = $checkOutDate;
             $booking->number_days = $request->number_days;
             $booking->bill = $totalPrice;
             $booking->save();



             // Create PDF
             $customPaper = array(0,0,841.8897637795,595.2755905512);
             $pdf = PDF::loadView('invoice',compact('booking','resort'))->setPaper($customPaper, 'landscape');
             $invoice = $pdf->download()->getOriginalContent();
             Storage::put('public/pdf/'.$booking->id.'.pdf', $invoice);

             $booking = Booking::findOrFail($booking->id);
             $booking->invoice = url('storage/pdf/'.$booking->id.'.pdf');
             $booking->update();

             // send mail usign job queue
             dispatch(new ClientInvoiceJob($booking,$resort));

             // Get Admin
             $user = User::first();
             dispatch(new AdminNotifyJob($booking,$user));



             $responce = [
                 'success' => true,
                 'message' => "booking confirmed successfully"
             ];





             return response()->json($responce,200);
         }

    }

    /**
     * Get All Booking data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookings(){
        $bookings = Booking::all();
        $responce = [
            'success' => true,
            'data' => $bookings,
            'message' => "Get all bookings"
        ];
        return response()->json($responce,200);
    }
}
