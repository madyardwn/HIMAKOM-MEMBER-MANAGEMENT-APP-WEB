<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ComplaintController extends Controller
{
    /**
     * Path to cabinet logos.
     */
    protected $path_screenshot_complaints;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_screenshot_complaints = config('dirpath.complaints.screenshots');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Complaint::with('user:id,name')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->make(true);
        }

        return view('pages.complaints.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'complaint' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            if ($request->hasFile('screenshot')) {
                $screenshot = $request->file('screenshot');
                $screenshot_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $screenshot->extension();
                $screenshot->storeAs($this->path_screenshot_complaints, $screenshot_name, 'public');
            } else {
                $screenshot_name = null;
            }

            $complaint = Complaint::create([
                'name' => $request->name,
                'complaint' => $request->complaint,
                'screenshot' => $screenshot_name,
                'user_id' => auth()->user()->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint created successfully!',
                'data' => $complaint,
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
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        try {
            $complaint->load('user:id,name');

            return response()->json([
                'status' => 'success',
                'data' => $complaint,
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'complaint' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            if ($request->hasFile('screenshot')) {
                deleteFile($this->path_screenshot_complaints . '/' .  $complaint->getAttributes()['screenshot']);
                $screenshot = $request->file('screenshot');
                $screenshot_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $screenshot->extension();
                $screenshot->storeAs($this->path_screenshot_complaints, $screenshot_name, 'public');
                $complaint->screenshot = $screenshot_name;
            }

            $complaint->update([
                'name' => $request->name,
                'complaint' => $request->complaint,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint updated successfully!',
                'data' => $complaint,
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
    public function destroy(Complaint $complaint)
    {
        try {
            if ($complaint->screenshot) {
                deleteFile($this->path_screenshot_complaints . '/' .  $complaint->screenshot);
            }
            $complaint->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }

    public function resolve(Complaint $complaint)
    {
        try {
            $complaint->update([
                'is_resolve' => true,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Complaint resolved successfully!',
                'data' => $complaint,
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
