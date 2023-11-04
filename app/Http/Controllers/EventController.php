<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Event;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    /**
     * Path to store posters.
     */
    private $path_poster_events;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_poster_events = config('dirpath.events.posters');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $typeExpression = 'CASE type ';
            foreach (Event::EVENT_TYPE as $key => $value) {
                $typeExpression .= 'WHEN ' . $key . ' THEN "' . $value . '" ';
            }
            $typeExpression .= 'END as type';

            $data = Event::select([
                'id',
                'name',
                'description',
                'location',
                'poster',
                'date',
                'link',
                'type',
                DB::raw($typeExpression),
            ]);

            return DataTables::of($data)->make();
        }

        return view('pages.events.index', [
            'types' => Event::EVENT_TYPE,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:events,name|max:50',
            'description' => 'required|max:255',
            'location' => 'required|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date',
            'type' => 'required|in:' . implode(',', array_keys(Event::EVENT_TYPE)),
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
            $poster = $request->file('poster');
            $poster_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $poster->extension();
            $poster->storeAs($this->path_poster_events, $poster_name, 'public');

            $event = Event::create([
                'poster' => $poster_name,
                'name' => $request->name,
                'description' => $request->description,
                'location' => $request->location,
                'date' => $request->date,
                'type' => $request->type,
                'link' => $request->link ?? '',
            ]);

            if (!Carbon::parse($event->date)->isPast()) {
                sendNotificationEvent($event);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Event created successfully!',
                'data' => $event,
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
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        try {
            return response()->json([
                'status' => 'success',
                'message' => 'Event fetched successfully!',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50|unique:events,name,' . $event->id,
            'description' => 'required|max:255',
            'location' => 'required|max:255',
            'date' => 'required|date',
            'type' => 'required|in:' . implode(',', array_keys(Event::EVENT_TYPE)),
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
            if ($request->hasFile('poster')) {
                if ($event->poster && file_exists(storage_path('app/public/' . $this->path_poster_events . '/' . $event->poster))) {
                    logFile($this->path_poster_events, $event->poster, 'UPDATED');
                }

                $poster = $request->file('poster');
                $poster_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $poster->extension();
                $poster->storeAs($this->path_poster_events, $poster_name, 'public');
                $event->poster = $poster_name;
            }

            $event->update([
                'name' => $request->name,
                'description' => $request->description,
                'location' => $request->location,
                'date' => $request->date,
                'type' => $request->type,
                'link' => $request->link ?? '',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Event updated successfully!',
                'data' => $event,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            if ($event->poster && file_exists(storage_path('app/public/' . $this->path_poster_events . '/' . $event->poster))) {
                logFile($this->path_poster_events, $event->poster, 'DELETED');
            }

            $event->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Event deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function notification(Event $event, Request $request)
    {
        try {
            if (Carbon::parse($event->date)->isPast()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Event ' . $event->name . ' has passed!',
                ], 403);
            }

            $notification = Notification::create([
                'title' => $request->title ?? 'Event ' . $event->name,
                'body' => $request->body ?? 'Event ' . $event->name . ' will be held on ' . $event->date . ' at ' . $event->location,
                'link' => $request->link ?? '',
                'poster' => $event->poster,
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

            return response()->json([
                'status' => 'success',
                'message' => 'Notification sent successfully!',
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
