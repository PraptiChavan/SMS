<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentFeeController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student class from the students table (if exists)
        $studentClass = Student::where('email', $student->email)->value('classes');

        // Fetch student mobile number from the students table
        $studentMobile = Student::where('email', $student->email)->value('mobile');

        return view('student.student-fee.student_fee', compact('student', 'studentClass', 'studentMobile'));
    }
}
