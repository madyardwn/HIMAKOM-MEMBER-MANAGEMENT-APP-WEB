<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*')
                ->when(!auth()->user()->hasRole('super-admin'), function ($query) {
                    return $query->where('id', '!=', 1);
                });
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
 
        return view('pages.users.index');
    }
}

