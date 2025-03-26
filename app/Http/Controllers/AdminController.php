<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
use App\Models\GeneralTask;
class AdminController extends Controller
{
    //
    public function addDep()
    {
        $departments = Department::all();

        return view('addDep',compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $currentDateTime = now();

        $request->validate([
            'category_name' => 'required|string|max:255', // Validate the correct input name
        ]);


       $department=Department::create([
            'get_Department' => $request->category_name, // Use the correct request key

        ]);


        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Add New Department ', // Random string of 10 characters
            'details' => 'Department Name: ' . $department->get_Department,
        ]);


        return redirect()->back()->with('message', 'Category added successfully');
    }

    public function editCatogary($id)
    {
        // Find the category by ID, or show 404 if not found
        $department = Department::findOrFail($id);
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Edit  Department Name', // Random string of 10 characters
            'details' => 'Department Name: ' . $department->get_Department,
        ]);
        // Return the view with the category data
        return view('editcatogary', compact('department'));
    }

    public function updateCatogary(Request $request,$id){
        $request->validate([
            'category_name'=>'required|string|max:255',]);
        $category = Department::findOrFail($id);
        $category->update([
            'get_Department'=>$request->category_name,
        ]);
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Update  Department Name', // Random string of 10 characters
            'details' => 'Updated Department Name: ' . $category->get_Department,
        ]);

        return redirect()->route('admin.addDep')->with('message', 'Category updated successfully');
    }


    public function deleteCategory($id)
    {
        $category = Department::findOrFail($id); // Fetch category or fail
        $category->delete(); // Delete the category
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Delete Department', // Random string of 10 characters
            'details' => 'Department Name: ' .   $category->get_Department,
        ]);

        return redirect()->back()->with('message','Department Deleted successfully');
    }

    public function userView()
    {
        $users = User::with('department', 'tasks')->get();
//        $task = Task::where('user_id', $userId)->first();
        foreach ($users as $user) {
            Activity::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'date' => now()->setTimezone('Asia/Kolkata')->toDateString(),
                'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(),
                'role' => $user->userType,
                'activity' => 'View User',
                'details' => 'User Name: ' . $user->name,
            ]);
        }

        return view('aa', compact('users',));
    }

    public  function assignTask(){
//     
        $department=Department::with('task')->get();
        $users = User::with('tasks')->get();

        return view('assignTask',compact('department','users'));
    }

    public function userUpdate(Request $request,$id){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:6',
        ]);
    }

    public function deleteUser($id)
    {
        // Find the post
        $post = User::findOrFail($id);

        // Delete the post from the database
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Remove user', // Random string of 10 characters
            'details' => 'User Name: ' .   $post->name,
        ]);

        $post->delete();

        // Redirect with success message
        return redirect()->route('admin.viewUser')->with('success', 'Post and associated files deleted successfully');
    }

    public function getUsersByDepartment(Request $request)
    {
        $departmentId = $request->input('department_id');  // Get department ID from request

        if ($departmentId) {
            // Fetch users that belong to the selected department
            $users = User::where('department_id', $departmentId,'tasks')->orderBy('created_at', 'desc')->get();  // Change department_id to get_department

            return response()->json([
                'users' => $users
            ]);
        }

        return response()->json([
            'users' => []
        ]);
    }


    public function getUserDetails(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::with('department','tasks')->find($userId); // Load department along with user
        $tasks = Task::where('user_id',$userId)->orderBy('created_at', 'desc')->get();
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'tasks' => $tasks,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ]);
        }
    }

    public function adminView($id)
    {
        $now = Carbon::now()->setTimezone('Asia/Colombo');
        $today = Carbon::today()->setTimezone('Asia/Colombo');
        $user = User::with('department','tasks')->findOrFail($id); // Fetch user with department
        $tasks = Task::where('user_id', $id)->orderBy('start_date', 'desc')->get();
        $todayTasks = Task::where('status', 'pending')
        ->whereDate('created_at', '=', $today)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('adminView', compact('user','tasks','todayTasks')); // Return the Blade view
    }



 public function taskStore(Request $request)
    {

        
        // Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $startTime = sprintf('%02d:%02d %s',
            $request->input('start-hour'),
            $request->input('start-minute'),
            $request->input('start-period')
        );

        $endTime = sprintf('%02d:%02d %s',
            $request->input('end-hour'),
            $request->input('end-minute'),
            $request->input('end-period')
        );

        $taskData = [
            'task_name' => $request->input('task_name'),
            'task_site' => $request->input('task_site'),
            'qty' => $request->input('qty'),
            'task_type' => $request->input('task_type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => $request->input('user_id'),
            'priority' => $request->input('priority'),
            'status' => 'pending',
            'allocated_by' => Auth::id(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'Duration_time'=> $request->input('getHour'),
        ];


        $task = Task::create($taskData);

        Activity::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/colombo')->toDateString(),
            'time' => now()->setTimezone('Asia/colombo')->toTimeString(),
            'role' => Auth::user()->userType,
            'activity' => 'Assign Task',
            'details' => 'Task: ' . $task->task_name . ' assigned to ' . ($task->user ? $task->user->name : 'Unknown'),
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

            return redirect()->route('admin.viewUser')->with('success', 'Task created successfully!');
        }

        return redirect()->route('admin.viewUser')->with('error', 'Failed to create task.');
    }





    public function Activity()
    {
        $users=User::all();
        return view('Activity',compact('users'));
    }
    public function userActivity($id)
    {
        $users = User::findOrFail($id);
        $activities = $users->TaskActivity; // Retrieve user's activities
        return view('userActivity', compact('users', 'activities'));
    }


    public function userEdit($id){
        $user = User::with('department')->findOrFail($id);
        $departments=Department::all();
        return view('userEdir', compact('user','departments'));
    }


    public function userEditFunc(Request $request, $id)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id, // Ignore the email validation for the current user
            'department' => 'required|exists:departments,id',
            'getRole' => 'required|string|in:admin,Coordinator,User',
            'Emp_id'=>'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for update
        ]);

        // Retrieve the existing user
        $user = User::findOrFail($id);

        // Update the user fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->department_id = $validated['department'];
        $user->Emp_id=$validated['Emp_id'];
        $user->userType = $validated['getRole'];

        // If a new password is provided, hash and update it
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        // Save the changes
        $user->save();
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Update  User Detailes', // Random string of 10 characters
            'details' => 'User Name is: ' .  $user->name,
        ]);


        // Redirect to a specific route (adjust to your actual route name)
        return redirect()->route('admin.viewUser')->with('success', 'User updated successfully!');
    }

    public function taskDelete($id){
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
        return redirect()->route('admin.assignTask')->with('success', 'Post and associated files deleted successfully');
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
        return view('updateTask', compact('task', 'hour', 'minute', 'period', 'end_hour', 'end_minute', 'end_period'));
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
//            'Duration_time' => 'required|numeric|min:0', // Ensure duration is at least 0
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

        return redirect()->route('admin.viewUser')->with('success', 'Task updated successfully!');
    }
    public function secondTask(Request $request)
    {
        // return $request;
        // Validate request
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $startTime = sprintf('%02d:%02d %s',
            $request->input('start-hour'),
            $request->input('start-minute'),
            $request->input('start-period')
        );

        $endTime = sprintf('%02d:%02d %s',
            $request->input('end-hour'),
            $request->input('end-minute'),
            $request->input('end-period')
        );

        $taskData = [
            'task_name' => $request->input('task_name'),
            'task_site' => $request->input('task_site'),
            'qty' => $request->input('qty'),
            'task_type' => $request->input('task_type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'user_id' => $request->input('user_id'),
            'priority' => $request->input('priority'),
            'status' => 'pending',
            'allocated_by' => Auth::id(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'Duration_time'=> $request->input('getHour'),
        ];


        $task = Task::create($taskData);

        Activity::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/colombo')->toDateString(),
            'time' => now()->setTimezone('Asia/colombo')->toTimeString(),
            'role' => Auth::user()->userType,
            'activity' => 'Assign Task',
            'details' => 'Task: ' . $task->task_name . ' assigned to ' . ($task->user ? $task->user->name : 'Unknown'),
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

            return redirect()->back()->with('success', 'Task updated successfully!');
        }

      
        return redirect()->back()->with('error', 'Failed to create task.');
        
    }
    public function extraTime(Request $request, $id) {
        // For debugging, log the request to check its values
        // return $request->all();
    
        $task = Task::find($id);
        if (!$task) {
            return redirect()->back()->with('error', 'Task not found!');
        }
    
        // Get values from the correct keys sent by JavaScript
        $startTime = $request->input('starttime'); // e.g., "09:30 AM"
        $endTime = $request->input('endtime');     // e.g., "05:45 PM"
        
        // Assign values to task object
        $task->user_id = $request->input('userid');
        $task->start_date = $request->input('startdate'); // Matches JS hidden input name
        $task->end_date = $request->input('enddate');
        $task->start_time = $startTime;
        $task->end_time = $endTime;
        $task->Duration_time = $request->input('duration');
        $task->save();
    
        Activity::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Colombo')->toDateString(),
            'time' => now()->setTimezone('Asia/Colombo')->toTimeString(),
            'role' => Auth::user()->userType,
            'activity' => 'Assign Task',
            'details' => 'Extended ' . ($task->user ? $task->user->name : 'Unknown') . "'s " . $task->task_name . ' time',
        ]);
    
        return redirect()->back()->with('success', 'Task updated successfully!');
    }
    public function extraTime2(Request $request, $id)
    {
        // Remove debug return statement
        return $request->all();
    
        try {
            $validated = $request->validate([
                'startdate' => 'required|date',
                'enddate' => 'required|date',
                'starttime' => 'required|string',
                'endtime' => 'required|string',
                'duration' => 'required|string',
                'user_id' => 'required|exists:users,id'
            ]);
    
            $task = Task::findOrFail($id);
    
            $task->update([
                'user_id' => $validated['user_id'],
                'start_date' => $validated['startdate'],
                'end_date' => $validated['enddate'],
                'start_time' => $validated['starttime'],
                'end_time' => $validated['endtime'],
                'Duration_time' => $validated['duration']
            ]);
    
            Activity::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'date' => now()->setTimezone('Asia/Colombo')->toDateString(),
                'time' => now()->setTimezone('Asia/Colombo')->toTimeString(),
                'role' => Auth::user()->userType,
                'activity' => 'Assign Task',
                'details' => 'Extended ' . ($task->user?->name ?? 'Unknown') . "'s " . $task->task_name . ' time',
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!'
            ]);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function oneTaskstore(Request $request){
        return $request;
        // $request->validate([
        //     'department' => 'required|exists:departments,id',  // Ensure the department exists
        //     'user' => 'required|exists:users,id',  // Ensure the user exists
        //     'task_name' => 'required|string|max:255',
        //     'priority' => 'required|in:low,medium,high',
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date',
        //     'job_description' => 'required|string',
        //     'allocated_by' => 'required|string',
        //     'start_hour' => 'required|integer|min:1|max:12',
        //     'start_minute' => 'required|integer|min:0|max:59',
        //     'start_period' => 'required|in:AM,PM',
        //     'end_hour' => 'required|integer|min:1|max:12',
        //     'end_minute' => 'required|integer|min:0|max:59',
        //     'end_period' => 'required|in:AM,PM',
        //     'enter_hour' => 'nullable|integer',
        // ]);
        

        // Calculate duration based on start and end times
        $startTime = sprintf('%02d:%02d %s',
        $request->input('start-hour'),
        $request->input('start-minute'),
        $request->input('start-period')
    );

    $endTime = sprintf('%02d:%02d %s',
        $request->input('end-hour'),
        $request->input('end-minute'),
        $request->input('end-period')
    );


        // Store the task in the database
        GeneralTask::create([
            'department_id' => $request->department,
            'user_id' => $request->user,
            'task_name' => $request->task_name,
            'priority' => $request->priority,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'job_description' => $request->job_description,
            'allocated_by' => Auth::user()->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_hour' =>$request->input('getHour'),
            'enter_hour' => $request->enter_hour,
            'time-range'=>$request->time-range,
            'general_task_type'=>$request->genearl-task-type,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Task created successfully!');
    }
    }
    

