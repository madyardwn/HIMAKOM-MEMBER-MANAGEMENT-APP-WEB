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
     * Path to Notification logos.
     */
    protected $path_poster_notifications;

    public function __construct()
    {
        $this->path_poster_notifications = config('dirpath.notifications.posters');
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Auto delete notifications...');
        $notifications = Notification::where('created_at', '<', now()->subMonth())->get();
        foreach ($notifications as $notification) {
            deleteFile($this->path_poster_notifications . '/' . $notification->getAttributes()['poster']);

            $notification->users()->detach();

            $notification->delete();
        }
        $this->info('Auto delete notifications done!');
    }
}
