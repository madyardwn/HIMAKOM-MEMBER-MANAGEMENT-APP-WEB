<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            $data = Event::select('*');

            return DataTables::of($data)->make();
        }

        return view('pages.events.index');
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
            'time' => 'required',
            'type' => 'required',
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
                'time' => $request->time,
                'type' => $request->type,
                'active' => Carbon::parse($request->date . ' ' . $request->time)->greaterThan(Carbon::now()),
            ]);

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
        $event_type = Event::EVENT_TYPE[$event->type];
        $event->type = [
            'id' => $event->type,
            'name' => $event_type,
        ];

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
            'time' => 'required',
            'type' => 'required|in:' . implode(',', array_keys(Event::EVENT_TYPE)),
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
                'time' => $request->time,
                'type' => $request->type,
                'is_active' => Carbon::parse($request->date . ' ' . $request->time)->greaterThan(Carbon::now()),
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
}
