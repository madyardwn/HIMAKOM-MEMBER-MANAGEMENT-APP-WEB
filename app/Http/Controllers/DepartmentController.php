<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * Path to department logos.
     */
    protected $path_logo_departments;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_logo_departments = config('dirpath.departments.logo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::select('*');

            return DataTables::of($data)->make(true);
        }

        return view('pages.departments.index');
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
            'name' => 'required|unique:departments,name|max:50',
            'short_name' => 'required|unique:departments,short_name|max:10',
            'description' => 'required|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $logo = $request->file('logo');
            $logo_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $logo->extension();
            $logo->storeAs($this->path_logo_departments, $logo_name, 'public');

            $department = Department::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
                'logo' => $logo_name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Department created successfully!',
                'data' => $department,
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
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $department,
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
    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departments,name,' . $department->id . '|max:50',
            'short_name' => 'required|unique:departments,short_name,' . $department->id . '|max:10',
            'description' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            if ($request->hasFile('logo')) {

                if ($department->logo && file_exists(storage_path('app/public/' . $this->path_logo_departments . '/' . $department->logo))) {
                    logFile($this->path_logo_departments, $department->logo, 'UPDATED');
                }

                $logo = $request->file('logo');
                $logo_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $logo->extension();
                $logo->storeAs($this->path_logo_departments, $logo_name, 'public');
                $department->logo = $logo_name;
            }

            $department->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Department updated successfully!',
                'data' => $department,
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
    public function destroy(Department $department)
    {
        try {
            if ($department->logo && file_exists(storage_path('app/public/' . $this->path_logo_departments . '/' . $department->logo))) {
                logFile($this->path_logo_departments, $department->logo, 'DELETED');
            }

            $department->cabinets()->detach();
            $department->users()->detach();

            $department->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Department deleted successfully!',
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
