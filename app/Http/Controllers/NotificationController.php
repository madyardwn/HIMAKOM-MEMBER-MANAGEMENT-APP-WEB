<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    /**
     * Path to Notification logos.
     */
    protected $path_poster_notifications;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_poster_notifications = config('dirpath.notifications.posters');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // count users
            $data = Notification::withCount('users')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->make(true);
        }

        return view('pages.notifications.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'body' => 'required|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $cabinet = Cabinet::where('is_active', 1)->first();

            if (!$cabinet) {
                throw new \Exception('Cabinet or users not found!');
            }

            $poster = $request->file('poster');
            $poster_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $poster->extension();
            $poster->storeAs($this->path_poster_notifications, $poster_name, 'public');

            $notification = Notification::create([
                'poster' => $poster_name,
                'title' => $request->title,
                'body' => $request->body,
                'link' => $request->link,
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

            return response()->json([
                'status' => 'success',
                'message' => 'Notification created successfully!',
                'data' => $notification,
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        return response()->json([
            'status' => 'success',
            'data' => $notification->load('users'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        try {
            deleteFile($this->path_poster_notifications . '/' . $notification->getAttributes()['poster']);

            $notification->users()->detach();

            $notification->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Notification deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
