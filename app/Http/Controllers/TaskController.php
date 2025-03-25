<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExpiringTaskMail;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    
    private function refreshTasks()
    {
        // Set the current time to Sri Lanka Standard Time (SLST)
        $now = Carbon::now('Asia/Colombo');
        $soonThreshold = $now->copy()->addMinutes(30); // 30-minute threshold

        Log::info("Current Time (IST): " . $now->toDateTimeString());
        Log::info("Soon Threshold (IST): " . $soonThreshold->toDateTimeString());



        $expiredTasks = Task::where('status', '!=', 'done')
            ->whereRaw("
        STR_TO_DATE(CONCAT(end_date, ' ', end_time), '%Y-%m-%d %h:%i %p') < ?",
                [$now->toDateTimeString()]
            )->get();
        // Fetch soon-to-expire tasks (within 30 minutes)
        $soonToExpireTasks = Task::where('status', '!=', 'done')
            ->whereRaw("CONVERT_TZ(CONCAT(end_date, ' ', end_time), '+00:00', '+05:30') BETWEEN ? AND ?", [
                $now->toDateTimeString(),
                $soonThreshold->toDateTimeString()
            ])->get();

        // Get task counts
        $expiredTaskCount = $expiredTasks->count();
        $soonToExpireTaskCount = $soonToExpireTasks->count();

        Log::info("Expired Tasks Count: " . $expiredTaskCount);
        Log::info("Soon-To-Expire Tasks Count: " . $soonToExpireTaskCount);

        return [
            'expiredTasks' => $expiredTasks,
            'soonToExpireTasks' => $soonToExpireTasks,
            'expiredTaskCount' => $expiredTaskCount,
            'soonToExpireTaskCount' => $soonToExpireTaskCount
        ];
    }



    private function generateDropdownMenu($tasks, $expiredTaskCount, $soonToExpireTaskCount)
    {
        $dropdownHtml = '<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">';
        $dropdownHtml .= '<span class="dropdown-item dropdown-header">' . count($tasks) . ' Notifications</span>';
        $dropdownHtml .= '<div class="dropdown-divider"></div>';

        // Display each task
        foreach ($tasks as $task) {
            $timeRemaining = Carbon::parse($task->end_date . ' ' . $task->end_time)->diffForHumans();
            $dropdownHtml .= '<a href="#" class="dropdown-item">';
            $dropdownHtml .= '<i class="fas fa-tasks mr-2"></i> ' . $task->title;
            $dropdownHtml .= '<span class="float-right text-muted text-sm">' . $timeRemaining . '</span>';
            $dropdownHtml .= '</a>';
            $dropdownHtml .= '<div class="dropdown-divider"></div>';
        }

        // Display expired & soon-to-expire counts
        $dropdownHtml .= '<span class="dropdown-item dropdown-header">Expired: ' . $expiredTaskCount . ' | Soon Expiring: ' . $soonToExpireTaskCount . '</span>';
        $dropdownHtml .= '</div>';

        return $dropdownHtml;
    }



    public function fetchNotifications(Request $request)
    {
        try {
            $tasksData = $this->refreshTasks();
            $dropdownMenuHtml = $this->generateDropdownMenu(
                $tasksData['expiredTasks']->merge($tasksData['soonToExpireTasks']),
                $tasksData['expiredTaskCount'],
                $tasksData['soonToExpireTaskCount']
            );

            return response()->json([
                'success' => true,
                'dropdown_menu' => $dropdownMenuHtml
            ]);
        } catch (\Exception $e) {
            Log::error("Error fetching notifications: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch notifications.'
            ], 500);
        }
    }



    public function pendingTask()
    {
        $tasksData = $this->refreshTasks();
        return view('pending', [
            'tasks' => $tasksData['expiredTasks']->merge($tasksData['soonToExpireTasks'])
        ]);
    }



    public function CoodinatorPendingTask()
    {
        $tasksData = $this->refreshTasks();
        return view('CoodinatorPending', [
            'tasks' => $tasksData['expiredTasks']->merge($tasksData['soonToExpireTasks'])
        ]);
    }



    public function headerActivity()
    {
        // $user=User
        $tasksData = $this->refreshTasks(); // Get expired & soon-to-expire tasks
        $tasks = Task::all(); // Get all tasks

        return view('dashboard', [
            'tasks' => $tasks,
            'expiredTaskCount' => $tasksData['expiredTaskCount'],
            'soonToExpireTaskCount' => $tasksData['soonToExpireTaskCount']
        ]);
    }

  
    
    


    public function MainDashBoard()
{
    $now = Carbon::now()->setTimezone('Asia/Colombo');
    $today = Carbon::today()->setTimezone('Asia/Colombo');

    // Retrieve departments
    $departments = Department::with('users')->get();

    // Retrieve tasks
    $todayTasks = Task::where('status', 'pending')
        ->whereDate('created_at', '=', $today)
        ->orderBy('created_at', 'desc')
        ->get();

        $todayAllTasks = Task::whereIn('status', ['pending', 'Done'])
        ->whereDate('end_date', '<=', $today) // Include today's tasks
        ->orderBy('end_date', 'desc')
        ->paginate(10);
    
    
        // ->groupBy('user_id');

    $pendingTasks = Task::where('status', 'pending')
        ->whereDate('end_date', '<', $today)
        ->orderBy('end_date', 'asc')
        ->get();

    $completedTasks = Task::where('status', 'done')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('adminDashboard', compact(
        'departments',
        'todayTasks',
        'pendingTasks',
        'completedTasks',
        'todayAllTasks',
        'now'
    ));
}

public function filterTasks(Request $request)
{
    $now = Carbon::now()->setTimezone('Asia/Colombo');
    $today = Carbon::today()->setTimezone('Asia/Colombo');

    // Get departments (needed for all views)
    $departments = Department::with('users')->get();

    // Base query
    $query = Task::query();

    if ($request->filled('user_name')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->user_name . '%');
        });
    }

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Get filtered tasks for each section
    $todayTasks = $query->clone()
        ->whereDate('created_at', '=', $today)
        ->orderBy('created_at', 'desc')
        ->get();

    $pendingTasks = $query->clone()
        ->where('status', 'pending')
        ->whereDate('end_date', '<', $today)
        ->orderBy('end_date', 'asc')
        ->get();

    $completedTasks = $query->clone()
        ->where('status', 'done')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('adminDashboard', compact(
        'departments',
        'todayTasks',
        'pendingTasks',
        'completedTasks',
        'now'
    ));
}

     public function CoordinatorDashBoard()
    {
        $now = Carbon::now()->setTimezone('Asia/Colombo');
        $today = Carbon::today()->setTimezone('Asia/Colombo');

        // Get departments
        $departments = Department::with('users')->get();
        

        // Get tasks for each section
        $todayTasks = Task::where('status', 'pending')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();
            $todayAllTasks = Task::whereIn('status', ['pending', 'Done'])
            ->whereDate('end_date', '<=', $today) // Include today's tasks
            ->orderBy('end_date', 'desc')
            ->paginate(10);
        

        $pendingTasks = Task::where('status', 'pending')
            ->whereDate('end_date', '<', $today)
            ->orderBy('end_date', 'asc')
            ->get();

        $completedTasks = Task::where('status', 'done')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Pass all variables to the view including departments
        return view('coodinatorDashboard', compact(
            'departments',
            'todayTasks',
            'todayAllTasks',
            'pendingTasks',
            'completedTasks',
            'now'
        ));
    }
    public function filterCoordinatorTasks(Request $request)
    {
        $now = Carbon::now()->setTimezone('Asia/Colombo');
        $today = Carbon::today()->setTimezone('Asia/Colombo');

        // Get departments
        $departments = Department::with('users')->get();

        // Base query
        $query = Task::query();

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Get filtered tasks
        $expiredTasks = $query->clone()
            ->where('status', 'pending')
            ->whereDate('end_date', '<', $today)
            ->get();

        $todayTasks = $query->clone()
            ->where('status', 'pending')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        $pendingTasks = $query->clone()
            ->where('status', 'pending')
            ->whereDate('end_date', '<', $today)
            ->orderBy('end_date', 'asc')
            ->get();

        $completedTasks = $query->clone()
            ->where('status', 'done')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('coodinatorDashboard', compact(
            'departments',
            'expiredTasks',
            'todayTasks',
            'pendingTasks',
            'completedTasks',
            'now'
        ));
    }
    


public function userDashboard()
    {
        $now = Carbon::now('Asia/Colombo');
        $tenMinutesLater = Carbon::now()->addMinutes(10); // Get time 10 minutes ahead

        $userId = Auth::id();
        $user = User::find($userId);
        $expiredTasks = Task::where('status', 'pending')
            ->where('user_id', $userId)
            ->whereDate('end_date', '<', $now->toDateString()) // Expired tasks
            ->get();

        $todayTasks = Task::where('status', 'pending')
            ->where('user_id', $userId)
            ->whereDate('end_date', '=', $now->toDateString()) // Tasks due today
            ->get();


        // Fetch tasks that are expiring in the next 10 minutes
      $expireTime=Task::where('status', 'pending')
          ->where('user_id', $userId)
          ->whereDate('end_time', '<', Carbon::now()->toDateString())
          ->get();
        if ( $expireTime->isNotEmpty() && $user) {
            if (!empty($user->email)) {
                try {
                    Mail::to($user->email)->send(new ExpiringTaskMail($expiredTasks));
                    Log::info("Expired task email sent successfully to " . $user->email);
                } catch (\Exception $e) {
                    Log::error("Failed to send expired task email: " . $e->getMessage());
                }
            } else {
                Log::warning("User has no email address: User ID " . $user->id);
            }
        }
        return view('userDashboadr', compact('expiredTasks', 'todayTasks', 'expireTime'));
    }

 
    
}
