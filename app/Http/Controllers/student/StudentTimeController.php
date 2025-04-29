<?php

namespace App\Http\Controllers\student;

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

class StudentTimeController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student class from the students table (if exists)
        $studentClass = Student::where('email', $student->email)->value('classes');

        // Fetch student class from the students table (if exists)
        $studentSection = Student::where('email', $student->email)->value('sections');

        $periods = PeriodModel::all();
        $weekdays = WeekdayModel::all();
        $accounts = Account::where('type', 'teacher')->get();
        // Retrieve all time entries
        $time = TimeModel::all();
        // Retrieve time entries filtered by class and section
        $time = TimeModel::where('classes', $studentClass)
        ->where('sections', $studentSection)
        ->get();
        
        // Pass time entries to the view
        return view('student.time-table.tt', compact('student', 'studentClass', 'studentSection', 'time', 'periods', 'weekdays', 'accounts'));
    }
}


