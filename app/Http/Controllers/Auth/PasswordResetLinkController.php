<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
{
    // Validate the email input
    $request->validate([
        'email' => 'required|email',
    ]);

    // Send email
    $details = [
        'title' => 'Password Reset Request',
        'body' => 'Click the link below to reset your password.'
    ];

    Mail::to($request->email)->send(new ForgotPassword($details));

    // Store success message in session
    return redirect()->back()->with('success', 'Email sent successfully! Please check your mail inbox.');
}
    public function emailRsetBlade(){
          return view('passwordReset');
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email', // Check if email exists in users table
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Find user by email
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
    
        // Update user password
        $user->password = Hash::make($request->password); // Hash the password before saving
        $user->save();
    
        return redirect()->route('login')->with('message', 'Category updated successfully');
      
    }
}
