<?php

namespace App\Http\Controllers;

use App\Models\DBU;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WorkHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('workHistories.cabinet:id,name', 'workHistories.dbu:id,name', 'workHistories.role:id,name')
                ->with('workHistories')
                ->where('id', '!=', 1);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.work-histories.index');
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ], 200);
    }

    public function positions(Request $request, User $user)
    {
        if ($request->ajax()) {
            $data = $user->workHistories()->with('cabinet:id,name', 'dbu:id,name', 'role:id,name');

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function programs(Request $request, User $user)
    {
        if ($request->ajax()) {
            $data = Program::with('lead:id,name', 'dbu:id,name', 'participants:id,name')
                ->where('user_id', $user->id)
                ->orWhereHas('participants', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
