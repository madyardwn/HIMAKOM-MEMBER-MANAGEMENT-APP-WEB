<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Path to store user pictures.
     */
    protected $path_picture_users;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->path_picture_users = config('dirpath.users.pictures');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('cabinets:id,name', 'roles:id,name', 'department:id,name')
                ->where('id', '!=', 1);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.users.index', [
            'gender' => User::GENDER_TYPE,
            'departments' => Department::all(['id', 'name']),
            'roles' => Role::all(['id', 'name'])->whereNotIn('name', ['super-admin']),
            'cabinets' => Cabinet::all(['id', 'name']),
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
            'name' => 'required|string|max:50',
            'nim' => 'required|string|max:10',
            'npa' => 'required|string|max:10',
            'name_bagus' => 'required|string|max:50',
            'gender' => 'required|in:0,1',
            'year' => 'required|string|max:4',
            'email' => 'required|string|email|max:255|unique:users',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8|confirmed',
            'cabinets' => 'required|array|exists:cabinets,id|not_in:1',
            'department' => 'required|numeric|exists:departments,id',
            'roles' => 'required|array|exists:roles,id|not_in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $picture = $request->file('picture');
            $picture_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $picture->extension();
            $picture->storeAs($this->path_picture_users, $picture_name, 'public');

            $user = User::create([
                'name' => $request->name,
                'nim' => $request->nim,
                'npa' => $request->npa,
                'name_bagus' => $request->name_bagus,
                'gender' => $request->gender,
                'year' => $request->year,
                'email' => $request->email,
                'picture' => $picture_name,
                'password' => bcrypt($request->password),
                'department_id' => $request->department,
            ]);

            $user->assignRole($request->roles);
            $user->cabinets()->attach($request->cabinets);

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully!',
                'data' => $user,
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        try {
            $user->load('cabinets:id,name', 'department:id,name', 'roles:id,name');
            return response()->json([
                'status' => 'success',
                'data' => $user,
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
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'nim' => 'required|string|max:10',
            'npa' => 'required|string|max:10',
            'name_bagus' => 'required|string|max:50',
            'year' => 'required|string|max:4',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'gender' => 'required|in:0,1',
            'cabinets' => 'required|array|exists:cabinets,id|not_in:1',
            'department' => 'required|numeric|exists:departments,id',
            'roles' => 'required|array|exists:roles,id|not_in:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            if ($request->hasFile('picture')) {

                if ($user->picture && file_exists(storage_path('app/public/' . $this->path_picture_users . '/' . $user->picture))) {
                    logFile($this->path_picture_users, $user->picture, 'UPDATED');
                }

                $picture = $request->file('picture');
                $picture_name = date('Y-m-d-H-i-s') . '_' . $request->name . '.' . $picture->extension();
                $picture->storeAs($this->path_picture_users, $picture_name, 'public');
                $user->picture = $picture_name;
            }

            $user->update([
                'name' => $request->name,
                'nim' => $request->nim,
                'npa' => $request->npa,
                'name_bagus' => $request->name_bagus,
                'gender' => $request->gender,
                'year' => $request->year,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'department_id' => $request->department,
            ]);

            $user->cabinets()->sync($request->cabinets);
            $user->roles()->sync($request->roles);

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!',
                'data' => $user,
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
    public function destroy(User $user)
    {
        try {
            if ($user->picture && file_exists(storage_path('app/public/' . $this->path_picture_users . '/' . $user->picture))) {
                logFile($this->path_picture_users, $user->picture, 'DELETED');
            }

            $user->cabinets()->detach();
            $user->roles()->detach();

            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully!',
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
