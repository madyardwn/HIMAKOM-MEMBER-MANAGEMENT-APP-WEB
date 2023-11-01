<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // {
    //     "user": {
    //       "name": "Achmadya Ridwan Ilyawan",
    //       "nim": "211511001",
    //       "email": "achmadya.ridwan.tif21@polban.ac.id",
    //       "na": "2136001",
    //       "year": "2021",
    //       "nama_bagus": "AVAST",
    //       "role": "staf ahli",
    //       "avatar": "http://dev.neracietas.site/storage/avatars/2136001.png"
    //     },
    //     "access_token": "14|BYjQGHX4sxDBoSlza5HdyP34hwdtogqcqqVc9gLl"
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:username|email',
            // 'username' => 'required_without:email|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only(['email', 'password']);

            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The given data was invalid.',
                ], 422);
            }

            $user = $request->user()->load('roles');
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login success.',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed.',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();
            $request->user()->device_token = null;
            $request->user()->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout success.',
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed.',
            ], 500);
        }
    }
}
