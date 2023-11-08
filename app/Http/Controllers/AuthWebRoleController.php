<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AuthWebRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::with('permissions:id,name')
                ->when(!auth()->user()->hasRole('SUPER ADMIN'), function ($query) {
                    return $query->where('id', '!=', 1);
                })
                ->orderBy('id', 'asc');

            return DataTables::of($data)
                ->make(true);
        }

        return view('pages.auth-web-roles.index', [
            'permissions' => Permission::all(['id', 'name']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        try {
            $role->load('permissions:id,name');

            return response()->json([
                'status' => 'success',
                'data' => $role,
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
            'name' => 'required|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $role = Role::create([
                'name' => $request->name,
            ]);

            $role->permissions()->sync($request->permissions);

            return response()->json([
                'status' => 'success',
                'message' => 'Role created successfully!',
                'data' => $role,
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
    public function show(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
            'permissions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $role->update([
                'name' => $request->name,
            ]);

            $role->permissions()->sync($request->permissions);

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully!',
                'data' => $role,
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
    public function destroy(Role $role)
    {
        try {
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully!',
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
