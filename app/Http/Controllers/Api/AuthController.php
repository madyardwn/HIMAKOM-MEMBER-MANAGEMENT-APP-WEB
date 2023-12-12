<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      description="Login user",
     *      tags={"APP MOBILE HIMAKOM"},
     *      @OA\RequestBody(
     *         required=true,
     *         description="User credentials",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *          @OA\Schema(
     *              required={"email", "password"},
     *              @OA\Property(property="email",    type="string", format="email", description="User email"),
     *              @OA\Property(property="password", type="string", format="password", description="User password"),
     *          )
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *     )
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The given data was invalid.",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     * ),
     * @OA\Response(
     *      response=500,
     *      description="Login failed.",
     *      @OA\MediaType(
     *          mediaType="application/json"
     *      )
     *  )
     * )
     */
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

            if (auth()->guard('sanctum')->check() && auth()->guard('sanctum')->user()->hasRole('NON ACTIVE')) {
                // Hapus semua token pengguna
                auth()->guard('sanctum')->user()->tokens()->delete();

                // Hapus token perangkat (jika diperlukan)
                auth()->guard('sanctum')->user()->device_token = null;
                auth()->guard('sanctum')->user()->save();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Your Account is suspended, please contact Admin.',
                ], 421);
            }


            $user = User::select('users.*', 'roles.name AS role_name')
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('users.id', $request->user()->id)
                ->first();
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

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     description="Logout user",
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
     *         description="Logout failed.",
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
