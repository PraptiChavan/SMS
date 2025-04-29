<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;
use App\Models\admin\SubjectModel;
use App\Models\admin\TimeModel;
use App\Models\admin\WeekdayModel;
use App\Models\admin\PeriodModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class TeacherTimeController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch teacher details from the accounts table
        $teacher = Account::where('id', $userId)->first();

        $periods = PeriodModel::all();
        $weekdays = WeekdayModel::all();
        $accounts = Account::where('type', 'teacher')->get();
        // Retrieve all time entries
        $time = TimeModel::all();
        
        // Pass time entries to the view
        return view('teacher.time-table.tt', compact('teacher', 'time', 'periods', 'weekdays', 'accounts'));
    }
}


