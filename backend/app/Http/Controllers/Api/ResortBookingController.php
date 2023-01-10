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



class ResortBookingController extends Controller
{
    //
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

         $result = Booking::where('resort_id',$id)
            ->whereBetween('booking_date', [$bookingDate, $checkOutDate])
            ->whereBetween('check_out_date', [$bookingDate, $checkOutDate])
            ->get();

         if(empty($result)){
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

             $responce = [
                 'success' => true,
                 'message' => "booking confirmed successfully"
             ];

             // send mail usign job queue
             dispatch(new ClientInvoiceJob($booking,$resort));

             // Get Admin
             $user = User::first();
             dispatch(new AdminNotifyJob($booking,$user));
         }else{
             $responce = [
                 'success' => False,
                 'message' => "Sorry, Resort is already booked!"
             ];
         }
        return response()->json($responce,200);
    }

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
