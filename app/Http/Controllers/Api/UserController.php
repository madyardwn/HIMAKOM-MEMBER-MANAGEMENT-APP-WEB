<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     description="Return data user profile",
     *     tags={"APP MOBILE HIMAKOM"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to get user data.",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
     */
    public function user(Request $request)
    {
        try {
            $user = User::select('users.*', 'roles.name AS role_name')
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.id', $request->user()->id)
                ->first();

            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get user data.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/user/device-token",
     *     description="Update device token when user login",
     *     tags={"APP MOBILE HIMAKOM"},
     *     security={{"sanctum":{}}},     
     *    @OA\RequestBody(
     *         required=true,
     *         description="Update device token when user login",
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"device_token"},
     *                  @OA\Property(property="device_token", type="string", example="device_token"),
     *              )
     *          ),
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update device token.",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated.",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
     */
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
