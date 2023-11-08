<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function events()
    {
        try {
            $events = Event::select('*')
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
