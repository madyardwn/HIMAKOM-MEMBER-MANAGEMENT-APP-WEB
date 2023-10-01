<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class TomSelectController extends Controller
{
    public function permissions(Request $request)
    {
        $permissions = Permission::select('id', 'name')
            ->where('name', 'LIKE', "%{$request->q}%")->get();

        return response()->json($permissions);
    }
}