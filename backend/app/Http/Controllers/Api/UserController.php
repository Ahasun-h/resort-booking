<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get All User Data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $user = User::all();
        $responce = [
            'success' => true,
            'data' => $user,
            'message' => "Get All User"
        ];
        return response()->json($responce,200);
    }

    /**
     * Store User Data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['user_id'] = $user->id;
        $success['name'] = $user->name;

        $responce = [
            'success' => true,
            'data' => $success,
            'message' => "User created successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Get Selected  user data
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $user = User::findOrFail($id);

        $responce = [
            'success' => true,
            'data' => $user,
            'message' => "User data get successfully"
        ];
        return response()->json($responce,200);
    }

    /**
     * Update user
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$id){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        // Get Selected user
        $user = User::findOrFail($id);

        // Check Old Password
        if(!Hash::check($data['old_password'], $user->password)){
            $responce =[
                'success' => false ,
                'message' => "Enter wrong old password"
            ];
        }else{
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($data['password']);
            $user->update();

            $responce = [
                'success' => true,
                'data' => $user,
                'message' => "User updated successfully"
            ];
        }

        return response()->json($responce,200);
    }

    /**
     * Delete selected user
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function delete($id){
        User::findOrFail($id)->delete();
        $responce = [
            'success' => true,
            'message' => "User deleted successfully"
        ];
        return response()->json($responce,200);

    }

}
