<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\GeneralTask;
use Illuminate\Console\Command;

class CheckDueTasks extends Command
{
    // Define the signature and description of the command
    protected $signature = 'tasks:check-due';
    protected $description = 'Check for due repeating tasks and create new ones with updated dates';

    public function handle()
    {
        $today = Carbon::today();

        // Get tasks where the due date (end_date) is today and that have a valid repetition setting
        $dueTasks = GeneralTask::whereDate('end_date', $today)
            ->whereIn('time_range', ['Day', 'Week', 'Month', 'Year'])
            ->get();

            

        foreach ($dueTasks as $task) {
            // Replicate the task. This copies all attributes except the primary key.
            $newTask = $task->replicate();

            // Update dates based on the repetition type
            switch ($task->time_range) {
                case 'Day':
                    $newTask->start_date = $today->toDateString();
                    $newTask->end_date = $today->copy()->addDay()->toDateString();
                    break;
                case 'Week':
                    $newTask->start_date = $today->toDateString();
                    $newTask->end_date = $today->copy()->addWeek()->toDateString();
                    break;
                case 'Month':
                    $newTask->start_date = $today->toDateString();
                    $newTask->end_date = $today->copy()->addMonth()->toDateString();
                    break;
                case 'Year':
                    $newTask->start_date = $today->toDateString();
                    $newTask->end_date = $today->copy()->addYear()->toDateString();
                    break;
                default:
                    // If task_type is not recognized, skip to the next task.
                    continue 2;
            }
            // Save the newly created task
            $newTask->save();

            $this->info("Created new repeating task for Task ID {$task->id}");
        }
    }
}
