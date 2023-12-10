<?php

use App\Models\Cabinet;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

if (!function_exists('sendNotificationEvent')) {
    function sendNotificationEvent($event, $message = null)
    {
        $cabinet = Cabinet::where('is_active', 1)->first();

        if (!$cabinet) {
            return;
        }

        try {
            $poster_name = $event->getAttributes()['poster']; // x.png
            $path_events_posters = config('dirpath.events.posters'); // events/posters
            $path_poster_notifications = config('dirpath.notifications.posters'); // notifications/posters

            $new_poster_name = date('Y-m-d-H-i-s') . '_FROM_EVENT_' . $event->getAttributes()['poster']; // 20200101_x.png
            Storage::disk('public')->copy($path_events_posters . '/' . $poster_name, $path_poster_notifications . '/' . $new_poster_name);

            $notification = Notification::create([
                'poster' => $new_poster_name,
                'title' => $message->title ??  'Event ' . $event->name,
                'body' => $message->body ?? 'Event ' . $event->name . ' will be held on ' . Carbon::parse($event->date)->format('d-m-Y H:i') . ' at ' . $event->location,
                'link' => $message->link ?? $event->link ?? '',
            ]);

            $url = env('FCM_URL');
            $serverKey = env('FCM_SERVER_KEY');

            $headers = [
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $data = [
                'event_id' => $notification->id,
            ];

            $fcmTokens = $cabinet->users()->whereNotNull('device_token')->pluck('device_token')->all();
            $chunks = array_chunk($fcmTokens, 50);

            foreach ($chunks as $chunk) {
                $fields = [
                    'registration_ids' => $chunk,
                    'notification' => $notification,
                    'data' => $data,
                ];

                $payload = json_encode($fields);

                $curl = curl_init();

                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $payload,
                    CURLOPT_HTTPHEADER => $headers,
                ]);

                $response = curl_exec($curl);

                if ($response === false) {
                    // Handle the cURL error here
                    throw new \Exception('cURL error: ' . curl_error($curl));
                }

                curl_close($curl);

                foreach ($chunk as $token) {
                    $user = User::where('device_token', $token)->first();

                    if ($user) {
                        $user->notifications()->attach(Notification::latest()->first()->id, [
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
