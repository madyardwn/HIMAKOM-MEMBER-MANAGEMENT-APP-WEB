<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     description="Return data events",
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
     *         description="Failed to get events data.",
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
    public function events()
    {
        try {
            $events = Event::select('*')
                ->where('date', '>=', Carbon::now())
                ->orderBy('date', 'ASC')
                ->get();

            $events->map(function ($event) {
                $event->type = Event::EVENT_TYPE[$event->type];
                return $event;
            });

            return response()->json([
                'status' => 'success',
                'data' => $events,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get events data.',
            ], 500);
        }
    }
}
