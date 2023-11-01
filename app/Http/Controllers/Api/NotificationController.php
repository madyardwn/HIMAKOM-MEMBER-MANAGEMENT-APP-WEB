<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // {
    //     "status": "success",
    //     "data": [
    //       {
    //         "id": 6,
    //         "title": "Event Speak Up Day",
    //         "body": "Event Speak Up Day akan dilaksanakan pada 2023-10-16 pukul 20:00:00 di Politeknik Negeri Bandung",
    //         "link": "",
    //         "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-04-51_Speak_Up_Day.png",
    //         "is_read": 0
    //       },
    //       {
    //         "id": 5,
    //         "title": "Event Speak Up Day",
    //         "body": "Event Speak Up Day akan dilaksanakan pada 2023-10-16 pukul 20:00:00 di Politeknik Negeri Bandung",
    //         "link": "",
    //         "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-04-51_Speak_Up_Day.png",
    //         "is_read": 0
    //       },
    //       {
    //         "id": 4,
    //         "title": "Event Tisigram",
    //         "body": "Event Tisigram akan dilaksanakan pada 2023-12-07 pukul 08:00:00 di Politeknik Negeri Bandung",
    //         "link": "",
    //         "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-02-54_Tisigram.jpg",
    //         "is_read": 0
    //       },
    //       {
    //         "id": 3,
    //         "title": "Event Tisigram",
    //         "body": "Event Tisigram akan dilaksanakan pada 2023-12-07 pukul 08:00:00 di Politeknik Negeri Bandung",
    //         "link": "",
    //         "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-02-54_Tisigram.jpg",
    //         "is_read": 0
    //       }
    //     ]
    //   }
    public function notifications(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
        ]);

        $notifications = $request->user()->notifications()
            ->where('data->title', 'like', '%' . $request->search . '%')
            ->orWhere('data->body', 'like', '%' . $request->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($notifications);
    }

    // {
    //     "status": "success",
    //     "data": {
    //       "id": 6,
    //       "title": "Event Speak Up Day",
    //       "body": "Event Speak Up Day akan dilaksanakan pada 2023-10-16 pukul 20:00:00 di Politeknik Negeri Bandung",
    //       "link": "",
    //       "poster": "http://dev.neracietas.site/storage/cabinets/events/poster/2023-10-07-07-04-51_Speak_Up_Day.png",
    //       "created_at": "2023-10-16T09:39:02.000000Z",
    //       "updated_at": "2023-10-16T09:39:02.000000Z"
    //     }
    // }
    public function read(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $notification = $request->user()->notifications()->findOrFail($request->id);
        $notification->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification has been read',
        ]);
    }
}
