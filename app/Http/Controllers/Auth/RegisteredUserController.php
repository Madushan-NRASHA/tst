<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Activity;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
//     public function store(Request $request)
//     {


//         $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
//             'department_id' => ['nullable'], 
//             'Emp_id' => ['required', 'string', 'max:255'],
//             'password' => ['required', 'confirmed', Rules\Password::defaults()],
//             'getRole'=>['required','string'],
//         ]);

//         $dep =$request['department'];

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'Emp_id' => $request->Emp_id,
//             'department_id' => $request-> department, // Fixed from $request->department
//             'password' => Hash::make($request->password),
//             'userType'=>$request->getRole,
//         ]);
//         $role=$request->input('getRole');



//         event(new Registered($user));

// //        Auth::login($user);
//         Activity::create([
//             'user_id'=>Auth::id(),
//             'name' => Auth::user()->name,
//             'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
//             'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
//             'role' => Auth::user()->userType,
//             'activity' =>'Add New User ', // Random string of 10 characters
//             'details' => 'User Name: ' . $user->name,
//         ]);

//         return redirect(route('admin.viewUser', absolute: false));
//     }

  public function store(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'Emp_id' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable'], // This is correct as is
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'getRole'=>['required','string'],
        ]);

        $dep =$request['department'];

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'Emp_id' => $request->Emp_id,
            'department_id' => $request-> department, // Fixed from $request->department
            'password' => Hash::make($request->password),
            'userType'=>$request->getRole,
        ]);
        $role=$request->input('getRole');



        event(new Registered($user));

//        Auth::login($user);
        Activity::create([
            'user_id'=>Auth::id(),
            'name' => Auth::user()->name,
            'date' => now()->setTimezone('Asia/Kolkata')->toDateString(), // Adjust date to UTC+5:30
            'time' => now()->setTimezone('Asia/Kolkata')->toTimeString(), // Adjust time to UTC+5:30
            'role' => Auth::user()->userType,
            'activity' =>'Add New User ', // Random string of 10 characters
            'details' => 'User Name: ' . $user->name,
        ]);

        return redirect(route('admin.viewUser', absolute: false));
    }
}
