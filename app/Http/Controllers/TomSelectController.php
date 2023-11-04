<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TomSelectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function users(Request $request)
    {
        $users = User::with('cabinet:id,name')
            ->select('id', 'name')
            ->where('name', 'like', '%' . $request->q . '%')
            ->whereNotIn('id', [1])
            ->whereHas('cabinet', function ($query) {
                $query->where('is_active', true);
            })
            ->get();

        return response()->json($users);
    }
}
