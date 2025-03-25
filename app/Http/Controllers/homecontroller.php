<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function adminDash(){
        $departments = Department::all();
        return view('admin', compact('departments'));
    }

    public function editorDash()
    {
        // Fetch all departments
        $department = Department::all();
        $users = User::all();

        // Fetch tasks assigned to the logged-in user
        $userId = auth()->id(); // Get the ID of the currently logged-in user
        $tasks = Task::where('user_id', $userId)->get(); // Retrieve tasks where user_id matches the logged-in user

        // Pass the data to the view
        return view('editor', compact('department', 'tasks','users'));
    }




}
