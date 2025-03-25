<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UserUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:mysql-table {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update pending tasks for a specific user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        // Fetch pending tasks for the specified user
        $tasks = DB::table('tasks')
            ->where('status', 'pending')
            ->where('user_id', $userId)
            ->get();

        foreach ($tasks as $task) {
            \Log::info('Task ID: ' . $task->id . ' is currently pending.');

            // Update the status to 'completed'
            DB::table('tasks')
                ->where('id', $task->id)
                ->update(['status' => 'completed']);

            \Log::info('Task ID: ' . $task->id . ' status updated to completed.');
        }

        if ($tasks->isEmpty()) {
            \Log::info('No tasks with "pending" status were found for user ID: ' . $userId);
        }

        $this->info('MySQL table checked and updated successfully for user ID: ' . $userId);
    }
}
