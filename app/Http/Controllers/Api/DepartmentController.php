<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function departments(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);

        $departments = Department::select('id', 'name', 'description', 'created_at', 'updated_at')
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return response()->json($departments);
    }
}
