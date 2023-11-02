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
    public function users(Request $request)
    {
        $users = User::select('id', 'name')
            ->whereNotIn('id', [1])
            ->where('name', 'like', '%' . $request->q . '%')
            ->get();

        return response()->json($users);
    }
}
