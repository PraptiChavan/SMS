<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\admin\ClassModel;
use App\Models\admin\Event;
use App\Http\Controllers\Controller; // Import the base Controller class

class DashboardController extends Controller
{
    // Restrict access to specific user types
    private function restrictAccess($type)
    {
        if (!Session::has('login')) {
            return redirect('/login')->withErrors(['error' => 'Please log in first.'])->send();
        }

        if (Session::get('user_type') !== $type) {
            abort(403, 'Unauthorized access');
        }
    }

    /**
     * Student dashboard.
     */
    public function student()
    {
        $this->restrictAccess('student'); 
        $events = Event::where('date', '>=', now())->orderBy('date', 'asc')->get();
        return view('student.dashboard', compact('events'));
    }

    /**
     * Admin dashboard.
     */
    public function admin()
    {
        $this->restrictAccess('admin');
        // Fetch classes for dropdown
        $classes = ClassModel::all();
        // Pass the $classes data to the view
        return view('admin.dashboard', compact('classes')); 
    }

    /**
     * Teacher dashboard (if needed).
     */
    public function parent()
    {
        $this->restrictAccess('parent');
        // Fetch upcoming events
        $events = Event::where('date', '>=', now())->orderBy('date', 'asc')->get();
        return view('parent.dashboard', compact('events'));
    }

    public function teacher()
    {
        $this->restrictAccess('teacher');
        // Fetch upcoming events
        $events = Event::where('date', '>=', now())->orderBy('date', 'asc')->get();
        return view('teacher.dashboard', compact('events'));
    }
    // Add similar methods for other user types (e.g., librarian, etc.)
}
