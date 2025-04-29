<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\admin\AdmitModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentAdmitCardController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Get student name from students table using email
        $studentName = Student::where('email', $student->email)->value('name');

        // Fetch only the admit cards belonging to the student
        $admitcards = AdmitModel::where('student_name', $studentName)->get();

        return view('student.admitcard.admitcard', compact('admitcards'));
    }
}
