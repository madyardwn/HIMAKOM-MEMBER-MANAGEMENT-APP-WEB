<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CabinetController extends Controller
{
    /**
     * Path to cabinet logos.
     */
    protected $path_logo_cabinets;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_logo_cabinets = config('dirpath.cabinets.logo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Cabinet::with('departments:id,name')
                ->orderBy('year', 'desc');

            return DataTables::of($data)
                ->make(true);
        }

        return view('pages.cabinets.index', [
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
            'name' => 'required|unique:cabinets,name|max:50',
            'description' => 'required|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'year' => 'required|numeric',
            'is_active' => 'required|boolean',
            'visi' => 'required',
            'misi' => 'required',
            'departments' => 'required|array|exists:departments,id',
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
            $logo->storeAs($this->path_logo_cabinets, $logo_name, 'public');

            $cabinet = Cabinet::create([
                'logo' => $logo_name,
                'name' => $request->name,
                'description' => $request->description,
                'year' => $request->year,
                'is_active' => $request->is_active,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);

            $cabinet->departments()->attach($request->departments);

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet created successfully!',
                'data' => $cabinet,
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
    public function show(Cabinet $cabinet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabinet $cabinet)
    {
        try {
            $cabinet->load('departments:id,name');

            return response()->json([
                'status' => 'success',
                'data' => $cabinet,
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
    public function update(Request $request, Cabinet $cabinet)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cabinets,name,' . $cabinet->id . '|max:50',
            'description' => 'required|max:255',
            'year' => 'required|numeric',
            'is_active' => 'required|boolean',
            'visi' => 'required',
            'misi' => 'required',
            'departments' => 'required|array',
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
                $logo = $request->file('logo');
                $logo_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $logo->extension();
                $logo->storeAs($this->path_logo_cabinets, $logo_name, 'public');
                $cabinet->logo = $logo_name;
            }

            $cabinet->update([
                'name' => $request->name,
                'description' => $request->description,
                'year' => $request->year,
                'is_active' => $request->is_active,
                'visi' => $request->visi,
                'misi' => $request->misi,
            ]);

            $cabinet->departments()->sync($request->departments);

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet updated successfully!',
                'data' => $cabinet,
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
    public function destroy(Cabinet $cabinet)
    {
        try {
            $cabinet->departments()->detach();
            $cabinet->users()->detach();

            $cabinet->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet deleted successfully!',
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
