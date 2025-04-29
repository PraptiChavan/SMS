<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\admin\ExamForm;
use App\Models\admin\ClassModel;
use App\Models\admin\SubjectModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentExamFormController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Student account not found');
        }

        // Fetch student class from the students table
        $studentClass = Student::where('email', $student->email)->value('classes');

        // Fetch only the exam schedules belonging to the student's class
        $examForms = ExamForm::where('classes', $studentClass)->get();

        return view('student.examform.examform', compact('examForms'));
    }
}
