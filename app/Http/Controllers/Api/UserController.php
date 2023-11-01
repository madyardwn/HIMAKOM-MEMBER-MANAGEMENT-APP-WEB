<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user()->load('roles');
    }

    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        try {
            $user = $request->user();
            $user->device_token = $request->device_token;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Device token updated successfully.',
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Device token failed to update.',
            ], 500);
        }
    }
}
