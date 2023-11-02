<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function users(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'users' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            Excel::import(new UserImport, $request->file('users'));
            return response()->json([
                'status' => 'success',
                'message' => 'Users imported successfully!',
            ], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
