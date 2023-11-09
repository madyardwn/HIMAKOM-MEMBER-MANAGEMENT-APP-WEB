<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cabinet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CabinetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cabinet",
     *     description="Return data cabinet",
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
     *         description="Failed to get cabinet data.",
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
    public function cabinet()
    {
        try {
            $cabinet = Cabinet::with('filosofies', 'users')
                ->withWhereHas('users', function ($query) {
                    $query->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->whereNotIn('roles.name', ['SUPER ADMIN', 'STAF MUDA', 'STAF AHLI', 'NON ACTIVE'])
                        ->orderByRaw('CASE roles.name
                            WHEN "KETUA HIMPUNAN" THEN 1
                            WHEN "WAKIL KETUA HIMPUNAN" THEN 2
                            
                            WHEN "KETUA MAJELIS PERWAKILAN ANGGOTA" THEN 3
                            WHEN "WAKIL KETUA MAJELIS PERWAKILAN ANGGOTA" THEN 4

                            WHEN "KETUA BIRO KEUANGAN" THEN 5
                            WHEN "WAKIL KETUA BIRO KEUANGAN" THEN 6

                            WHEN "KETUA BIRO ADMINISTRASI DAN KESEKRETARIATAN" THEN 7
                            WHEN "WAKIL KETUA BIRO ADMINISTRASI DAN KESEKRETARIATAN" THEN 8

                            WHEN "KETUA BIRO KOMUNIKASI DAN INFORMASI" THEN 9
                            WHEN "WAKIL KETUA BIRO KOMUNIKASI DAN INFORMASI" THEN 10

                            WHEN "KETUA DEPARTEMEN RISET, PENDIDIKAN, DAN TEKNOLOGI" THEN 11
                            WHEN "WAKIL KETUA DEPARTEMEN RISET, PENDIDIKAN, DAN TEKNOLOGI" THEN 12

                            WHEN "KETUA DEPARTEMEN PENGEMBANGAN SUMBER DAYA ANGGOTA" THEN 13
                            WHEN "WAKIL KETUA DEPARTEMEN PENGEMBANGAN SUMBER DAYA ANGGOTA" THEN 14

                            WHEN "KETUA DEPARTEMEN SENI DAN OLAHRAGA" THEN 15
                            WHEN "WAKIL KETUA DEPARTEMEN SENI DAN OLAHRAGA" THEN 16

                            WHEN "KETUA DEPARTEMEN LUAR HIMPUNAN" THEN 17
                            WHEN "WAKIL KETUA DEPARTEMEN LUAR HIMPUNAN" THEN 18

                            WHEN "KETUA DEPARTEMEN ROHANI ISLAM" THEN 19
                            WHEN "WAKIL KETUA DEPARTEMEN ROHANI ISLAM" THEN 20

                            WHEN "KETUA UNIT KEWIRAUSAHAAN" THEN 21
                            WHEN "WAKIL KETUA UNIT KEWIRAUSAHAAN" THEN 22

                            WHEN "KETUA UNIT TEKNOLOGI" THEN 23
                            WHEN "WAKIL KETUA UNIT TEKNOLOGI" THEN 24

                            ELSE 25
                        END')
                        ->select('users.*', 'roles.name AS role_name');
                })
                ->where('is_active', 1)
                ->first();

            return response()->json([
                'status' => 'success',
                'data' => $cabinet,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get users.',
            ], 500);
        }
    }
}
