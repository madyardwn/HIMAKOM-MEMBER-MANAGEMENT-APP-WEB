<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // {
    //     "status": "success",
    //     "data": [
    //       {
    //         "id": 3,
    //         "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-04-51_Speak_Up_Day.png",
    //         "name": "Speak Up Day",
    //         "description": "kegiatan berbagi ilmu dan/atau\r\npengalaman pribadi, baik dalam hal akademik maupun non\r\nakademik,",
    //         "date": "2023-10-30",
    //         "time": "20:00:00",
    //         "location": "Politeknik Negeri Bandung",
    //         "type": "kegiatan"
    //       }
    //     ]
    // }
    public function events(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);

        $events = Event::select('id', 'name', 'description', 'created_at', 'updated_at')
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%')
            ->orderBy('name', 'asc')
            ->paginate(10);

        return response()->json($events);
    }
}
