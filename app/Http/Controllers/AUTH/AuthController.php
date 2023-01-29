<?php

namespace App\Http\Controllers\AUTH;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validate->fails()) {
            $response = [
                'success' => false,
                'messege' => $validate->errors()
            ];

            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =$user->createToken('MyApp')->plainTextToken;
        $success['name'] =$user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'messege' => 'User registered successfully'
        ];

        return response([$response, 200]);

    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email'=> $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user  =$request->user();
            $success['token'] =$user->createToken('MyApp')->plainTextToken;
            $success['name'] =$user->name;

            $response = [
                'success' => true,
                'data' => $success,
                'messege' => 'User login successfully'
            ];

            return response()->json($response, 200);
        }
    }
}
