<?php


// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\Auth\LoginRequest;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\View\View;

// class AuthenticatedSessionController extends Controller
// {
//     /**
//      * Display the login view.
//      */
//     public function create(): View
//     {
//         return view('auth.login');
//     }

//     /**
//      * Handle an incoming authentication request.
//      */
//     public function store(LoginRequest $request): RedirectResponse
//     {

//         // Authenticate the user based on the request
//         $request->authenticate();

//         // Regenerate the session to protect against session fixation
//         $request->session()->regenerate();

//         // Check the user type and redirect accordingly
//         if ($request->user()->userType == 'admin') {
//             // Redirect to the admin dashboard

//             return redirect()->intended(route('adminView.Dashboard'));
//         }

//         if ($request->user()->userType == 'Coordinator') {
//             // Redirect to the coordinator/editor dashboard
//             return redirect()->intended(route('Coordinator.DashBoard'));
//         }

//         // Default redirection if user type is neither admin nor coordinator
//         return redirect()->intended(route('user.dashboard', [], false));
//     }



//     /**
//      * Destroy an authenticated session.
//      */
//     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::guard('web')->logout();

//         $request->session()->invalidate();

//         $request->session()->regenerateToken();

//         return redirect('/');
//     }
// }
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; 
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
 
     public function store(LoginRequest $request)
     {
         // Attempt to validate user credentials without logging in
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // Generate OTP and send via email
        $otp = $user->generateOtp();

        // Send OTP via email (Uncomment when mail is configured correctly)
        Mail::to($user->email)->send(new OtpMail($otp));

        // Store user ID in session for 2FA verification
        session(['2fa:user:id' => $user->id]);

        // Redirect to OTP verification page
        return view('auth.2fa_verify', compact('otp'))->with('success', 'OTP has been sent to your email.');
     }
     
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
