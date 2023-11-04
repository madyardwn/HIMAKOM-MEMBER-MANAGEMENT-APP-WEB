<?php

namespace App\Console\Commands;

use App\Models\Cabinet;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
            try {
                sendNotificationEvent($event);
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
        }
    }
}
