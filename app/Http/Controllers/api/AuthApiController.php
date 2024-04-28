<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'name' => 'required|string|min:1',
            'password' => 'required|string|min:6|regex:/^(?=.*[A-Z])(?=.*\d).+$/|confirmed'
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'The fields with format is invalid.',
            ], 422);
        }

        try {
            $user = User::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->name,
                    'password' => Hash::make($request->password)
                ]
            );

            if ($user->wasRecentlyCreated) {
                return response()->json([
                    'status' => true,
                    'message' => 'User created successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User already exists'
                ], 422);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        $validateUser = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|regex:/^(?=.*[A-Z])(?=.*\d).+$/'
        ]);

        if ($validateUser->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'The fields with format is invalid.',
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
                'data' => $user,
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ],200);
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
