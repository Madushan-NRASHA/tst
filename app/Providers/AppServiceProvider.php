<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Task;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('components.header', function ($view) {
            $now = Carbon::now('Asia/Colombo'); // Current time in Sri Lanka Standard Time
            $soonThreshold = $now->copy()->addMinutes(30); // Threshold for soon-to-expire tasks

            // Fetch tasks where status isn't 'done'
            $tasksQuery = Task::where('status', '!=', 'done');

            // Count expired tasks
            $expiredTaskCount = (clone $tasksQuery)
                ->whereRaw("CONVERT_TZ(CONCAT(end_date, ' ', end_time), '+00:00', '+05:30') < ?", [
                    $now->toDateTimeString()
                ])
                ->count();

            // Count tasks that will expire soon (within the next 30 minutes)
            $soonToExpireTaskCount = (clone $tasksQuery)
                ->whereRaw("CONCAT(end_date, ' ', end_time) BETWEEN ? AND ?", [
                    $now->toDateTimeString(),
                    $soonThreshold->toDateTimeString()
                ])
                ->count();

            // Fetch all incomplete tasks
            $tasks = $tasksQuery->get();

            // Pass the data to the header component
            $view->with([
                'tasks' => $tasks,
                'expiredTaskCount' => $expiredTaskCount,
                'soonToExpireTaskCount' => $soonToExpireTaskCount,
            ]);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        //
    }
}
