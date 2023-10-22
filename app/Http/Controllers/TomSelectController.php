<?php

namespace App\Http\Controllers;

use App\Models\Cabinet;
use App\Models\Department;
use App\Models\Event;
use App\Models\Permission;
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

    public function eventTypes(Request $request)
    {
        // $eventTypes = [
        //     ['id' => 1, 'name' => 'kegiatan'],
        //     ['id' => 2, 'name' => 'proker'],
        //     ['id' => 3, 'name' => 'lomba'],
        //     ['id' => 4, 'name' => 'project'],
        // ];

        foreach (Event::EVENT_TYPE as $key => $value) {
            $eventTypes[] = [
                'id' => $key,
                'name' => $value,
            ];
        }

        // search object by name
        $eventTypes = array_filter($eventTypes, function ($item) use ($request) {
            if (strpos(strtolower($item['name']), strtolower($request->q)) !== false) {
                return true;
            }
            return false;
        });

        return response()->json($eventTypes);
    }
}
