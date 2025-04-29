<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentProfileController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student details from the students table
        $studentData = Student::where('email', $student->email)->first();

        // Fetch the class title using the class ID
        $studentClass = ClassModel::where('id', $studentData->classes)->value('title');

        // Fetch student class from the students table (if exists)
        $studentDOB = Student::where('email', $student->email)->value('dob');

        // Fetch student class from the students table (if exists)
        $studentMobile = Student::where('email', $student->email)->value('mobile');

        // Fetch student address from the students table (if exists)
        $studentAddress = Student::where('email', $student->email)->value('address');

        // Fetch student address from the students table (if exists)
        $studentState = Student::where('email', $student->email)->value('state');

        // Fetch student address from the students table (if exists)
        $studentCountry = Student::where('email', $student->email)->value('country');

        // Fetch student address from the students table (if exists)
        $studentZip = Student::where('email', $student->email)->value('zip');

        // Fetch student class from the students table (if exists)
        $students = Student::all();

        // Pass time entries to the view
        return view('student.profile.profile', compact('student', 'studentData', 'studentClass', 'studentDOB', 'studentMobile', 'studentAddress', 'studentState', 'studentCountry', 'studentZip', 'students'));
    }
}


