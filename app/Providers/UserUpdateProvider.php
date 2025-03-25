<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Carbon\Carbon;
class UserUpdateProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.userHeader', function ($view) {
            $user = Auth::user();

            if ($user) {
                $now = Carbon::now('Asia/Colombo');
                $soonThreshold = $now->copy()->addMinutes(30);

                // Fetch expired tasks count for the authenticated user
                $expiredTaskCount = Task::where('status', '!=', 'done')
                    ->where('user_id', $user->id)
                    ->whereRaw("CONVERT_TZ(CONCAT(end_date, ' ', end_time), '+00:00', '+05:30') < ?", [
                        $now->toDateTimeString()
                    ])
                    ->count();

                // Fetch soon-to-expire tasks count for the authenticated user
                $soonToExpireTaskCount = Task::where('status', '!=', 'done')
                    ->where('user_id', $user->id)
                    ->whereRaw("CONVERT_TZ(CONCAT(end_date, ' ', end_time), '+00:00', '+05:30') BETWEEN ? AND ?", [
                        $now->toDateTimeString(),
                        $soonThreshold->toDateTimeString()
                    ])
                    ->count();

                // Fetch all pending tasks for the authenticated user
                $tasks = Task::where('status', '!=', 'done')
                    ->where('user_id', $user->id)
                    ->get();

                // Pass the data to the header view
                $view->with([
                    'tasks' => $tasks,
                    'expiredTaskCount' => $expiredTaskCount,
                    'soonToExpireTaskCount' => $soonToExpireTaskCount
                ]);
            }
        });
    }
}
