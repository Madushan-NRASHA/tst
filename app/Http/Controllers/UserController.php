<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    //
    public function UserView()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();
    
        // Retrieve only pending tasks for the authenticated user
        $tasks = Task::where('user_id', $userId)
                    ->where('status', 'pending')
                    ->orderBy('start_date', 'desc')
                    ->get();
    
        // Return tasks to the dashboard view (even if empty)
        return view('dashboard', compact('tasks'));
    }
    
    

  public function AddTask(Request $request, $taskId)
    {
        $validated = $request->validate([
            'status' => 'required|in:Done,pending',
        ]);

        $task = Task::findOrFail($taskId);

        // Calculate extra time only when status is being set to Done
        if ($validated['status'] === 'Done') {
            // Create Carbon instance from date and time correctly
            try {
                // Parse the end date and time separately and combine them
                $endDate = Carbon::parse($task->end_date)->format('Y-m-d');
                $endTime = Carbon::parse($task->end_time)->format('H:i:s');
                $endDateTime = Carbon::parse($endDate . ' ' . $endTime)
                                   ->setTimezone('Asia/Colombo');

                // Get current time in Asia/Colombo timezone
                $currentDateTime = now()->setTimezone('Asia/Colombo');

                // Only calculate extra time if completion is after end time
                if ($currentDateTime->gt($endDateTime)) {
                    // Calculate the difference
                    $diff = $currentDateTime->diff($endDateTime);

                    // Format the difference as days, hours, and minutes
                    $extraTime = [];

                    if ($diff->d > 0) {
                        $extraTime[] = $diff->d . ' days';
                    }
                    if ($diff->h > 0) {
                        $extraTime[] = $diff->h . ' hours';
                    }
                    if ($diff->i > 0) {
                        $extraTime[] = $diff->i . ' minutes';
                    }

                    // If task completed on time, set extra_time to "0"
                    $task->extra_time = !empty($extraTime) ? implode(', ', $extraTime) : '0';
                } else {
                    $task->extra_time = '0';
                }
            } catch (\Exception $e) {
                // Handle any parsing errors
                $task->extra_time = 'Error calculating extra time';
                \Log::error('Error calculating task extra time: ' . $e->getMessage());
            }
        }

        $task->status = $validated['status'];
        $task->save();

        Activity::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Colombo')->toDateString(),
            'time' => now()->setTimezone('Asia/Colombo')->toTimeString(),
            'role' => Auth::user()->userType,
            'activity' => ($task->user ? $task->user->name : 'Unknown') . ' ' . 'Update Task Status',
            'details' => ' My ' . ' ' . 'task' . ' ' . 'is' . ' ' . $task->status,
        ]);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
    // public function AddTask(Request $request,$taskId){
    //     $validated = $request->validate([
    //         'status' => 'required|in:Done,pending', // Ensure status is either 'close' or 'pending'
    //     ]);
    //     $task = Task::findOrFail($taskId);
    //     $task->status = $validated['status'];
    //     $task->save();
    //     Activity::create([
    //         'user_id'=>Auth::id(),
    //         'name' => Auth::user()->name,
    //         'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
    //         'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
    //         'role' => Auth::user()->userType,
    //         'activity' =>($task->user ? $task->user->name : 'Unknown') .' ' . 'Update Task Status', // Random string of 10 characters
    //         'details' =>    ' My  ' . ' ' . 'task'  .' '. 'is' . ' '. $task->status,


    //     ]);
    //     return redirect()->back()->with('success', 'Task status updated successfully!');
    // }
    
    public function userReason(Request $request, $task)
{
    // You can access the form data via $request->input('key') or $request->all()
    
    // Return specific form data (e.g., reasons or task details)
    $tasks = Task::findOrFail( $task);

    $tasks->update([
        'task_reason' => $request->input('delete_reason'),
    ]);
    return redirect()->back()->with('success', 'Task updated successfully!');
   
}
public function user_profile(Request $request, $id)
{
    // To inspect request data, use dd($request); but remember to remove it after debugging.
    // dd($request);

    // Find the user by ID
    $user = User::findOrFail($id);
    
    // Check if an image was uploaded
    if ($request->hasFile('image')) {
        $image = $request->file('image');  // Assuming you're uploading only one image

        // Generate a unique name for the image
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();

        // Store the image in the 'public' disk, in the 'image' directory
        $path = $image->storeAs('images', $imageName, 'public');

        $user->update([
            'user_img' => $path,
        ]);
    }

    // Redirect back with success message
    return redirect()->back()->with('success', 'Profile updated successfully!');
}
public function doneView()
{
    // Get the authenticated user's ID
    $userId = auth()->id();

    // Retrieve tasks with 'done' status for the logged-in user
    // $tasks = Task::where('user_id', $userId)
    //             ->where('status', 'done')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    $tasks = Task::where('user_id', $userId)
            ->where(function($query) {
                $query->where('status', 'done')
                      ->orWhere('Coordinator_status', 'done');
            })
            ->orderBy('created_at', 'desc')
            ->get();

    return view('done', compact('tasks'));
}
public function userUpdate(Request $request,$id){
    // $user=User::findOrFail($id);
    // $departments=Department::all();
    // return view('userUpdate',compact('user','departments'));
    $task = DB::table('tasks')->where('id', $id)->first(); // Fetch the task

    // Default values in case start_time is null
    $user = User::with('department')->findOrFail($id);
        $departments=Department::all();
        return view('userUpdate', compact('user','departments'));
}
public function userEditFunc(Request $request, $id)
{
    // return $request;
    // Validate the input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        // 'email' => 'required|email|max:255|unique:users,email,' . $id, // Ignore email validation for the current user
        // 'department' => 'required|exists:departments,id',
        // 'getRole' => 'required|string|in:admin,Coordinator,User',
        'Emp_id' => 'required|string|max:255',
        'password' => 'nullable|string|min:8|confirmed', // Password is optional for update
    ]);

    // Retrieve the existing user
    $user = User::findOrFail($id);

    // Update the user fields
    $user->name = $validated['name'];
    // $user->email = $request->email;
    // $user->department_id = $request->department;
    // $user->Emp_id = $validated['Emp_id'];
    // $user->userType = $validated['getRole'];

    // If a new password is provided, hash and update it
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    // Save the user updates
    $user->save();

    // Fetch the updated user's pending tasks
    $tasks = Task::where('user_id', $id)
        ->where('status', 'pending')
        ->orderBy('start_date', 'desc')
        ->get();

    // Log the activity
    Activity::create([
        'user_id' => Auth::id(),
        'name' => Auth::user()->name,
        'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust to UTC+5:30
        'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust to UTC+5:30
        'role' => Auth::user()->userType,
        'activity' => 'Updated User Details',
        'details' => 'User Name: ' . $user->name,
    ]);

    // Redirect to dashboard with success message
    return redirect()->route('dashboard')->with('success', 'User updated successfully.');
}
}
