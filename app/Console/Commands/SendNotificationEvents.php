<?php

namespace App\Console\Commands;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotificationEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-notification-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function handle()
    {
        $events = Event::whereDate('date', Carbon::now()->addDay())->get();

        foreach ($events as $event) {
            sendNotificationEvent($event);
        }
    }
}
