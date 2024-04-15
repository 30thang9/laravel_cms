<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function signUp(Request $request)
    {
//        $data = $request->validate([
//            'email' => 'required|string|unique:users|email',
//            'name' => 'required|string',
//            'password' => 'required|string|min:6|regex:/^(?=.*[A-Z])(?=.*\d).+$/|confirmed'
//        ]);
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|string|unique:users|email',
                'name' => 'required|string',
                'password' => 'required|string|min:6|regex:/^(?=.*[A-Z])(?=.*\d).+$/|confirmed'
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Request invalid',
                        'errors' => $validateUser->errors()
                    ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User created successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ],201);
        }catch (\Exception $e) {
            return response()->json(
                [
                   'status' => false,
                   'message' => $e->getMessage()
                ], 500);
        }

    }
    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6|regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ]);

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Request invalid',
                        'errors' => $validateUser->errors()
                    ], 422);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User login successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ],200);

        }catch (\Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ], 500);
        }

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logged out'
        ]);
    }

}
