<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResortController extends Controller
{
    //
    public function store(Request $request){

        dd ($request->all());

//        $request->validate([
//            'name'            => 'required|string',
//            'description'     => 'required',
//            'address'         => 'required|string',
//            'location'        => 'required|string',
//            'price_per_night' => 'required|numeric|regex:^[1-9][0-9]+|not_in:0',
//            'thumbnail_img'   => 'required',
//        ]);
//
//        return 'test';

    }
}
