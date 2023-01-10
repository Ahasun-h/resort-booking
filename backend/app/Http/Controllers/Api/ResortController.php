<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resort;
use App\Models\ResortImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ResortController extends Controller
{
    /**
     * Get all resort form database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $resort = Resort::all();
        $responce = [
            'success' => true,
            'data' => $resort,
            'message' => "Get all resort"
        ];
        return response()->json($responce,200);
    }

    /**
     * Store resort data in database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        $request->validate([
            'name'            => 'required|string',
            'description'     => 'required',
            'address'         => 'required|string',
            'location'        => 'required|string',
            'price_per_night' => 'required|numeric',
            'images'          => 'required',
        ]);

        // store resort
        $resort = new Resort();
        $resort->name = $request->name;
        $resort->description = $request->description;
        $resort->address = $request->address;
        $resort->location = $request->location;
        $resort->price_per_night = $request->price_per_night;
        $resort->save();

        // Count images
        $count = count($request->images);

        // Store resort image store database and file
        for ($i=0; $i < $count; $i++) {

            $image_64 = $request['images'][$i];
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10).'.'.$extension;
            Storage::disk('public')->put('resort-image/' . $imageName, base64_decode($image));

            $resortImage = new ResortImage();
            $resortImage->resort_id = $resort->id;
            $resortImage->image = url('storage/resort-image/'.$imageName);
            $resortImage->save();
        }
        $responce = [
            'success' => true,
            'message' => "Resort created successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Get selected resort data form database
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $resort = Resort::findOrFail($id);

        $responce = [
            'success' => true,
            'data' => $resort,
            'message' => "Resort data get successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Update resort in database
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id){
        $request->validate([
            'name'            => 'required|string',
            'description'     => 'required',
            'address'         => 'required|string',
            'location'        => 'required|string',
            'price_per_night' => 'required|numeric',
        ]);

        // update resort
        $resort = Resort::findOrFail($id);
        $resort->name = $request->name;
        $resort->description = $request->description;
        $resort->address = $request->address;
        $resort->location = $request->location;
        $resort->price_per_night = $request->price_per_night;
        $resort->update();

        // check if there any images
        if($request->has('images')){
            // Count images
            $count = count($request->images);

            // Store resort image store database and file
            for ($i=0; $i < $count; $i++) {

                $image_64 = $request['images'][$i];
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = Str::random(10).'.'.$extension;
                Storage::disk('public')->put('resort-image/' . $imageName, base64_decode($image));

                $resortImage = new ResortImage();
                $resortImage->resort_id = $id;
                $resortImage->image = url('storage/resort-image/'.$imageName);
                $resortImage->save();
            }
        }

        $responce = [
            'success' => true,
            'message' => "Resort updated successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Delete Resort and Resort image
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        ResortImage::where('resort_id',$id)->delete();
        Resort::findOrFail($id)->delete();

        $responce = [
            'success' => true,
            'message' => "Resort deleted successfully"
        ];
        return response()->json($responce,200);
    }




}
