<?php

namespace App\Http\Controllers;

use App\Models\DBU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DBUController extends Controller
{
    /**
     * Path to dbu logos.
     */
    protected $path_logo_dbus;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_logo_dbus = config('dirpath.dbus.logo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DBU::select('*');

            return DataTables::of($data)->make(true);
        }

        return view('pages.dbus.index');
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
            'name' => 'required|unique:dbus,name|max:50',
            'short_name' => 'required|unique:dbus,short_name|max:10',
            'description' => 'required',
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
            $logo->storeAs($this->path_logo_dbus, $logo_name, 'public');

            $dbu = DBU::create([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
                'logo' => $logo_name,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'DBU created successfully!',
                'data' => $dbu,
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
    public function show(DBU $dbu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DBU $dbu)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $dbu,
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
    public function update(Request $request, DBU $dbu)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:dbus,name,' . $dbu->id . '|max:50',
            'short_name' => 'required|unique:dbus,short_name,' . $dbu->id . '|max:10',
            'description' => 'required',
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
                deleteFile($this->path_logo_dbus . '/' . $dbu->getAttributes()['logo']);
                $logo = $request->file('logo');
                $logo_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $logo->extension();
                $logo->storeAs($this->path_logo_dbus, $logo_name, 'public');
                $dbu->logo = $logo_name;
            }

            $dbu->update([
                'name' => $request->name,
                'short_name' => $request->short_name,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'DBU updated successfully!',
                'data' => $dbu,
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
    public function destroy(DBU $dbu)
    {
        try {
            $dbu->cabinets()->detach();

            deleteFile($this->path_logo_dbus . '/' . $dbu->getAttributes()['logo']);
            $dbu->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'DBU deleted successfully!',
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
