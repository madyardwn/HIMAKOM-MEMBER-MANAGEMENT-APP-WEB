<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
            $data = User::with('cabinets:id,name', 'roles:id,name', 'departments:id,name')
                ->when($request->search['value'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('nim', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('npa', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('name_bagus', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('year', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('email', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhere('gender', 'like', '%' . $request->search['value'] . '%');
                    $query->orWhereHas('cabinets', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search['value'] . '%');
                    });
                    $query->orWhereHas('departments', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search['value'] . '%');
                    });
                    $query->orWhereHas('roles', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search['value'] . '%');
                    });
                })
                ->select('users.*')
                ->where('id', '!=', 1);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.users.index', [
            'gender' => User::GENDER_TYPE,
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
            'cabinets' => 'required|array',
            'departments' => 'required|array',
            'roles' => 'required|array',
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
            ]);

            $user->assignRole($request->roles);
            $user->cabinets()->attach($request->cabinets);
            $user->departments()->attach($request->departments);

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
            $user->load('cabinets:id,name', 'departments:id,name', 'roles:id,name');

            $user->gender = [
                'id' => $user->gender,
                'name' => User::GENDER_TYPE[$user->gender]
            ];

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
            'cabinets' => 'required|array',
            'departments' => 'required|array',
            'roles' => 'required|array',
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
            ]);

            $user->cabinets()->sync($request->cabinets);
            $user->departments()->sync($request->departments);
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
            $user->departments()->detach();
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
