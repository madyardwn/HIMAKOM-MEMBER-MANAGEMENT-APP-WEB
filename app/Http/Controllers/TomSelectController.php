<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Event;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class TomSelectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function permissions(Request $request)
    {
        $permissions = Permission::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($permissions);
    }

    /**
     * Display a listing of the resource.
     */
    public function cabinets(Request $request)
    {
        $cabinets = Cabinet::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($cabinets);
    }

    /**
     * Display a listing of the resource.
     */
    public function users(Request $request)
    {
        $users = User::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($users);
    }

    /**
     * Display a listing of the resource.
     */
    public function departments(Request $request)
    {
        $departments = Department::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($departments);
    }

    /**
     * Display a listing of the resource.
     */
    public function roles(Request $request)
    {
        $roles = Role::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($roles);
    }
}
