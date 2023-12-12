<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNonActiveApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
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

        return $next($request);
    }
}
