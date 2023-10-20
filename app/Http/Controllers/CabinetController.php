<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CabinetController extends Controller
{
    // create variable and constructor for path photo
    protected $path_logo;

    public function __construct()
    {
        $this->path_logo = config('dirpath.cabinets.logo');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
     {
         if ($request->ajax()) {
            $data = Cabinet::select([
                'id', 
                'name', 
                'description', 
                'year', 
                'is_active', 
                'visi', 
                'misi',
                DB::raw("CONCAT('".asset($this->path_logo)."/', logo) as logo")
            ]);
             
             return DataTables::of($data)
                ->make(true);
         }
  
         return view('pages.cabinets.index');
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
            'is_active' => 'required|numeric',
            'visi' => 'required|max:255',
            'misi' => 'required|max:255',
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
            $logo_name = time() . '_' . $request->name . '.' . $logo->extension();
            $logo->move(public_path($this->path_logo), $logo_name);

            $cabinet = Cabinet::create([
                'logo' => $logo_name,
                'name' => $request->name,
                'description' => $request->description,
                'year' => $request->year,
                'is_active' => $request->is_active,
                'visi' => $request->visi,
                'misi' => $request->misi,                
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet created successfully!',
                'data' => $cabinet,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
                'error' => $e->getMessage(),
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
        // map the logo path
        $cabinet->logo = asset($this->path_logo) . '/' . $cabinet->logo;

        try {
            return response()->json([
                'status' => 'success',
                'data' => $cabinet,
            ], 200);
        } catch (\Exception $e) {
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
            'is_active' => 'required|numeric',
            'visi' => 'required|max:255',
            'misi' => 'required|max:255',            
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
                $logo_name = time() . '_' . $request->name . '.' . $logo->extension();
                $logo->move(public_path($this->path_logo), $logo_name);
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

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet updated successfully!',
                'data' => $cabinet,
            ], 200);
        } catch (\Exception $e) {
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
            $cabinet->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cabinet deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong!',
            ], 500);
        }
    }
}
