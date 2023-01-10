<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResortImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResortImageController extends Controller
{
    /**
     * Get selected resort all image
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id){
        $resortImages = ResortImage::where('resort_id',$id)->get();

        $responce = [
            'success' => true,
            'data' => $resortImages,
            'message' => "Resort images data get successfully"
        ];

        return response()->json($responce,200);
    }

    /**
     * Delete resort image
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){

        $resortImage = ResortImage::findOrFail($id);
        $image = str_replace('http://127.0.0.1:8000/storage/', '', $resortImage->image);
        Storage::delete('resort-image/' .$image);
        $resortImage->delete();
        $responce = [
            'success' => true,
            'message' => "Resort images deleted successfully"
        ];
        return response()->json($responce,200);
    }


}
