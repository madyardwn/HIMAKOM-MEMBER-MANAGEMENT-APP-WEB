<?php

use App\Models\Cabinet;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Carbon;

if (!function_exists('sendNotificationEvent')) {
    function sendNotificationEvent($event)
    {
        $notification = Notification::create([
            'poster' => $event->poster,
            'title' => $event->name,
            'body' => $event->description,
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

        $cabinet = Cabinet::where('is_active', 1)->first();
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
    }
}
