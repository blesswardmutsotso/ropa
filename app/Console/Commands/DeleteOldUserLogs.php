<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserActivity;

class DeleteOldUserLogs extends Command
{
    protected $signature = 'logs:clean';
    protected $description = 'Delete user logs older than 5 minutes';

    public function handle()
    {
        UserActivity::where('created_at', '<', now()->subMinutes(5))->delete();

        $this->info('Old user logs deleted successfully.');
        return 0;
    }
}
