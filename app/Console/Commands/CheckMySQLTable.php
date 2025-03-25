<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckMySQLTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:mysql-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the MySQL table every hour and update the status column.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch rows where status needs to be updated (for example, status = 'pending')
        $tasks = DB::table('tasks')->where('status', 'pending')->get();

        // If there are any tasks with a 'pending' status, log them and update the status
        foreach ($tasks as $task) {
            \Log::info('Task ID: ' . $task->id . ' is currently pending.');

            // Example: Update the status to 'completed' after checking
            DB::table('tasks')
                ->where('id', $task->id)
                ->update(['status' => 'completed']);

            \Log::info('Task ID: ' . $task->id . ' status updated to completed.');
        }

        // If no tasks found with 'pending' status, log that as well
        if ($tasks->isEmpty()) {
            \Log::info('No tasks with "pending" status were found.');
        }

        $this->info('MySQL table checked and updated successfully.');
    }
}
