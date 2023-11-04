<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Program::select('*')->with('lead:id,name', 'department:id,name', 'participants:id,name');

            return DataTables::of($data)->make();
        }

        return view('pages.programs.index', [
            'departments' => Department::all(['id', 'name']),
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
            'name' => 'required|unique:programs,name|max:50',
            'description' => 'required|max:255',
            'lead' => 'required|numeric|exists:users,id|not_in:1',
            'department' => 'required|numeric|exists:departments,id',
            'participants' => 'required|array|exists:users,id|not_in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $program = Program::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $request->lead,
                'department_id' => $request->department,
            ]);

            $program->participants()->attach($request->participants);

            return response()->json([
                'status' => 'success',
                'message' => 'Program created successfully!',
                'data' => $program,
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
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        try {
            $program->load('lead:id,name', 'department:id,name', 'participants:id,name');

            return response()->json([
                'status' => 'success',
                'data' => $program,
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
    public function update(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:programs,name,' . $program->id . '|max:50',
            'description' => 'required|max:255',
            'lead' => 'required|numeric|exists:users,id|not_in:1',
            'department' => 'required|numeric|exists:departments,id',
            'participants' => 'required|array|exists:users,id|not_in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $program->update([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $request->lead,
                'department_id' => $request->department,
            ]);

            $program->participants()->sync($request->participants);

            return response()->json([
                'status' => 'success',
                'message' => 'Program updated successfully!',
                'data' => $program,
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
    public function destroy(Program $program)
    {
        try {

            $program->participants()->detach();

            $program->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Program deleted successfully!',
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
