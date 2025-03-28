<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorAuthController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.2fa_verify'); // Blade view for OTP verification
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);
    
        // Retrieve the user from the session
        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Please login again.']);
        }
    
        $user = User::find($userId);
        if (!$user || !$user->verifyOtp($request->otp)) {
            // Redirect back to the 2FA verification form with an error message
            return redirect()->route('2fa.verify')
                             ->withInput()
                             ->withErrors(['otp' => 'Invalid or expired OTP. Please try again.']);
        }
    
        // OTP verified, remove session data and log in the user
        session()->forget('2fa:user:id');
        Auth::login($user);
    
        // Redirect based on user role
        return $this->redirectUserBasedOnRole($user);
    }
    
    

private function redirectUserBasedOnRole($user)
{
    return match ($user->userType) {
        'admin' => redirect()->intended(route('adminView.Dashboard')),
        'General Manager' => redirect()->intended(route('adminView.Dashboard')),
        'Coordinator' => redirect()->intended(route('Coordinator.DashBoard')),
        default => redirect()->intended(route('user.dashboard')),
    };
}

}

