<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\StudyMaterials; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\SubjectModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class StudentStudyMaterialsController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student class from the students table
        $studentClass = Student::where('email', $student->email)->value('classes');

        // Fetch only the study materials belonging to the student's class
        $studymaterials = StudyMaterials::where('classes', $studentClass)->get();

        // Fetch subjects and classes for reference
        $subjects = SubjectModel::all();
        $classes = ClassModel::all();

        return view('student.studymaterials.studymaterials', compact('subjects', 'classes', 'studymaterials'));
    }
}
