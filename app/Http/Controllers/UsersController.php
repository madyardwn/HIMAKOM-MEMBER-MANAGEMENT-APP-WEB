<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> 
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
 
        return view('pages.users.index');
    }
}

