<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function notifications(Request $request)
    {
        try {
            $notifications = $request->user()->notifications()
                ->where('is_read', false)
                ->orderBy('created_at', 'DESC')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $notifications,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get notifications data.',
            ], 500);
        }
    }

    public function read(Request $request, Notification $notification)
    {
        try {
            $request->user()->notifications()->where('notification_id', $notification->id)->update([
                'is_read' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Notification read successfully.',
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Notification failed to read.',
            ], 500);
        }
    }
}
