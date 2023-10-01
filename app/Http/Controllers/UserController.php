<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
 
        return view('pages.users-management.users.index');
    }
}

