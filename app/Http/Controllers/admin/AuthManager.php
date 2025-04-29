<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\Account; // Updated reference to the model's namespace

class AuthManager extends Controller
{
    /**
     * Handle login requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Fixed missing validation for password
        ]);

        $email = $request->email;
        $password = $request->password;

        // Check if the email exists in the accounts table
        $user = Account::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            
            // Set session variables
            Session::put('login', true);
            Session::put('session_id', uniqid());  // Fixed typo (yySession to Session)
            Session::put('user_type', $user->type);
            Session::put('user_id', $user->id);

            // Redirect to the appropriate dashboard based on user type
            if ($user->type === 'student') {
                return redirect('/student/dashboard')->with('success', 'Student Login successful');
            } else {
                return redirect("/{$user->type}/dashboard")->with('success', 'Login successful');
            }
        }
            // Check hardcoded admin credentials
        elseif ($email === 'admin@example.com' && $password === 'admin@sms') {
            Session::put('login', true);
            Session::put('user_type', 'admin');
            Session::put('user_id', 1); // You can set admin's user_id to 1 (or whichever ID you want)

            // Redirect to the admin dashboard
            return redirect('/admin/dashboard')->with('success', 'Admin Login successful');
        }
        else{
            // Return back with an error message if no match
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }

    /**
     * Handle logout requests.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // Clear session
        Session::flush(); // Clear all session data

        // Redirect to the login page with a success message
        return redirect('/login')->with('success', 'Logged out successfully');
    }
}
