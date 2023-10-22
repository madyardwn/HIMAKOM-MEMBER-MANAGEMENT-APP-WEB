<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Filosofie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FilosofieController extends Controller
{
    /**
     * Path to filosofie logos.
     */
    protected $path_logo_filosofies;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_logo_filosofies = config('dirpath.cabinets.filosofies');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()){

            $data = Filosofie::select("*")
                ->with('cabinet:id,name');

            return DataTables::of($data)->make();
        }

        return view('pages.filosofies.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cabinet' => 'required|exists:cabinets,id',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'label' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $cabinet = Cabinet::find($request->cabinet);

            $logo = $request->file('logo');
            $logo_name = date('Y-m-d-H-i-s') . '_' . $cabinet->name . '.' . $logo->extension();
            $logo->storeAs($this->path_logo_filosofies, $logo_name, 'public');

            $filosofie = Filosofie::create([
                'cabinet_id' => $request->cabinet,
                'logo' => $logo_name,
                'label' => $request->label,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Filosofie created successfully!',
                'data' => $filosofie,
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
    public function show(Filosofie $filosofie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filosofie $filosofie)
    {
        try {
            $filosofie->load('cabinet:id,name');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Filosofie fetched successfully!',
                'data' => $filosofie,
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
    public function update(Request $request, Filosofie $filosofie)
    {
        $validator = Validator::make($request->all(), [
            'cabinet' => 'required|exists:cabinets,id',
            'label' => 'required|max:255',
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
                if ($filosofie->logo && file_exists(storage_path('app/public/' . $this->path_logo_filosofies . '/' . $filosofie->logo))) {                          
                    logFile($this->path_logo_filosofies, $filosofie->logo, 'DELETED');
                }

                $cabinet = Cabinet::find($request->cabinet);
                $logo = $request->file('logo');
                $logo_name = date('Y-m-d-H-i-s') . '_' . $cabinet->name . '.' . $logo->extension();
                $logo->storeAs($this->path_logo_filosofies, $logo_name, 'public');
                $filosofie->logo = $logo_name;
            }

            $filosofie->update([
                'cabinet_id' => $request->cabinet,
                'label' => $request->label,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Filosofie updated successfully!',
                'data' => $filosofie,
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
    public function destroy(Filosofie $filosofie)
    {
        try {
            if ($filosofie->logo && file_exists(storage_path('app/public/' . $this->path_logo_filosofies . '/' . $filosofie->logo))) {                          
                logFile($this->path_logo_filosofies, $filosofie->logo, 'DELETED');
            }
            $filosofie->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Filosofie deleted successfully!',
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
