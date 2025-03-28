<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;
use App\Models\Department;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoordinatorController extends Controller
{
    //
    // Method to update task status
    public function updateStatus(Request $request, $taskId)
    {
        // Validate the request
        $validated = $request->validate([
            'status' => 'required|in:Done,pending,Not Done', // Ensure status is either 'close' or 'pending'
        ]);

        // Find the task by ID
        $task = Task::findOrFail($taskId);

        // Update the task's status
        $task->Coordinator_status = $validated['status'];
        $task->save();
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Update Task Status', // Random string of 10 characters
            'details' => ($task->user ? $task->user->name : 'Unknown')   . ' s ' . $task->task_name .' '. 'is' . ' '. $task->Coordinator_status,


        ]);


        // Redirect back with a success message
        return redirect()->back()->with('success', 'Task status updated successfully!');
    }

    public function CoodinatorJob(){
        $department=Department::with('task')->get();
        $users = User::with('tasks')->get();

        return view('CoodinatorJob',compact('department','users'));
    }
    public function CoordinatorView($id){
//        $department = Department::findOrFail($id);
        $user = User::with('department', 'tasks')->find($id); // Load user, department, and tasks
        $tasks = Task::where('user_id', $id)->orderBy('start_date', 'desc')->get();

        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'View user', // Random string of 10 characters
            'details' => 'User Name: ' .   $user->name,
        ]);

        return view('CoodinatorView',compact('user','tasks'));

    }
    public function CoodinatorAsignTask(Request $request)
    {
// Process and format the start time
        $startTime = sprintf(
            '%02d:%02d %s',
            $request->input('start-hour'),
            $request->input('start-minute'),
            $request->input('start-period')
        );

        // Process and format the end time
        $endTime = sprintf(
            '%02d:%02d %s',
            $request->input('end-hour'),
            $request->input('end-minute'),
            $request->input('end-period')
        );

        // Prepare the data for creating a task
        $taskData = [
            'task_name' => $request->input('task_name'),
            'task_site' => $request->input('task_site'),    // Make sure this matches
            'qty' => $request->input('qty'),
            'task_type' => $request->input('task_type'),    // Changed from task-type to task_type
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => $request->input('user_id'),
            'priority' => $request->input('priority'),
            'status' => 'pending',
            'allocated_by' => Auth::id(),
            'start_time' => $startTime,
            'end_time' => $endTime
        ];

        // Create the task
        $task=Task::create($taskData);
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Assign Task', // Random string of 10 characters
            'details' => 'Task: ' . $task->task_name . ' Assign to ' . ($task->user ? $task->user->name : 'Unknown'),


        ]);
        if ($task) {
            // Only proceed with email if we have a user_id
            if ($task->user_id) {
                $user = \App\Models\User::find($task->user_id);

                if ($user) {
                    if ($user->email) {
                        // try {
                        //     // Send email
                        //     Mail::to($user->email)->send(new TaskAssignedMail($task));
                        // } catch (\Exception $e) {
                        //     // Log the error, and specifically capture MailTrap issues
                        //     if (strpos($e->getMessage(), 'MailTrap') !== false) {
                        //         \Log::error('MailTrap related issue when sending task assignment email: ' . $e->getMessage());
                        //     } else {
                        //         \Log::error('Failed to send task assignment email: ' . $e->getMessage());
                        //     }
                        // }
                        try {
    Mail::to($user->email)->send(new TaskAssignedMail($task));
    \Log::info('Email sent successfully to: ' . $user->email);
} catch (\Exception $e) {
    \Log::error('Email sending failed: ' . $e->getMessage());
    \Log::error('Stack trace: ' . $e->getTraceAsString());
}
                    } else {
                        \Log::warning('User has no email address: User ID ' . $user->id);
                    }
                } else {
                    \Log::warning('User not found for task assignment: User ID ' . $task->user_id);
                }
            }

            return redirect()->route('editor.dashboard')->with('success', 'Task created successfully!');
        }

        return redirect()->route('editor.dashboard')->with('error', 'Failed to create task.');
    }

    public function CoodinatortaskDelete($id){
        $task=Task::findOrFail($id);
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Remove' . ' ' . $task->user->name . 's' . ' ' .  'task', // Random string of 10 characters
            'details' => 'task Name: ' .   $task->task_name,
        ]);

        $task->delete();

        // Redirect with success message
        return redirect()->route('coordinator.jobAssign')->with('success', 'Post and associated files deleted successfully');
    }
    public function updateTaskview($id) {
        $task = DB::table('tasks')->where('id', $id)->first(); // Fetch the task

        // Default values in case start_time is null
        $hour = '';
        $minute = '';
        $period = '';
        $end_hour='';
        $end_minute='';
        $end_period='';
        if (!empty($task->start_time)) {
            $timeFormatted = date('h:i A', strtotime($task->start_time)); // Convert to 12-hour format
            list($hour, $minute) = explode(':', date('h:i', strtotime($timeFormatted)));
            $period = date('A', strtotime($timeFormatted));
        }
        if (!empty($task->end_time)) {
            $timeFormatted = date('h:i A', strtotime($task->end_time)); // Convert to 12-hour format
            list( $end_hour,  $end_minute) = explode(':', date('h:i', strtotime($timeFormatted)));
            $end_period= date('A', strtotime($timeFormatted));
        }
        return view('coodinatorUpdateTask', compact('task', 'hour', 'minute', 'period', 'end_hour', 'end_minute', 'end_period'));
    }


public function UpdateTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'task_site' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'start-hour' => 'required|numeric|between:1,12',
            'start-minute' => 'required|numeric|between:0,59',
            'start_period' => 'required|in:AM,PM',
            'end-hour' => 'required|numeric|between:1,12',
            'end-minute' => 'required|numeric|between:0,59',
            'end_period' => 'required|in:AM,PM',
            // 'Duration_time' => 'required|numeric|min:0', // Ensure duration is at least 0
        ]);

//         Convert 12-hour format to 24-hour time


        $startTime = Carbon::createFromFormat(
            'g:i A',
            sprintf("%d:%02d %s", $request->input('start-hour'), $request->input('start-minute'), $request->input('start_period'))
        )->format('h:i A'); // Keep 12-hour format with AM/PM





        $endTime = Carbon::createFromFormat(
            'g:i A',
            sprintf("%d:%02d %s", $request->input('end-hour'), $request->input('end-minute'), $request->input('end_period'))
        )->format('h:i A'); // 12-hour format with AM/PM

        // Update the task
        $task->update([
            'task_name' => $request->input('task_name'),
            'task_site' => $request->input('task_site'),
            'qty' => $request->input('qty'),
            'task_type' => $request->input('task_type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => $request->input('user_id'),
            'priority' => $request->input('priority'),
            'allocated_by' => Auth::id(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'Duration_time'=>$request->input('getHour'),
        ]);

        // Log activity
        Activity::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(),
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(),
            'role' => Auth::user()->userType,
            'activity' => 'update task',
            'details' => 'Task Name: ' . $task->task_name,
        ]);

        return redirect()->route('coordinator.jobAssign')->with('success', 'Task updated successfully!');
    }
}




