<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request){

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email'=> $request->email,'password'=> $request->password])){

            $user = $request->user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user_id'] = $user->id;
            $success['name'] = $user->name;

            $responce = [
                'success' => true,
                'data' => $success,
                'message' => "User login successfully"
            ];
            return response()->json($responce,200);
        }else{
            $responce =[
                'success' => false ,
                'message' => "Enter wrong credential"
            ];

            return response()->json($responce,400);
        }
    }
}
