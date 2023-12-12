<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class AutoDeleteNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-delete-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto delete notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Auto delete notifications...');
        $notifications = Notification::where('created_at', '<', now()->subMonth())->get();
        foreach ($notifications as $notification) {
            deleteFile(config('dirpath.notifications.posters') . '/' . $notification->getAttributes()['poster']);

            $notification->users()->detach();

            $notification->delete();
        }
        $this->info('Auto delete notifications done!');
    }
}
