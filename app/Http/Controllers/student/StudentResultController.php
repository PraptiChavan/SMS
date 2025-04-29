<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\admin\ResultModel;
use App\Models\admin\ExamForm;
use App\Models\admin\SubjectModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentResultController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student name from the students table
        $studentName = Student::where('email', $student->email)->value('name');

        // Fetch only the results belonging to the student
        $results = ResultModel::where('student_name', $studentName)->get();

        return view('student.results.results', compact('results'));
    }
}
