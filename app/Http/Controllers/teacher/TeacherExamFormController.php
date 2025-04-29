<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ExamForm; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\SubjectModel;


class TeacherExamFormController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        $examform = ExamForm::all();// Fetch all sections from the database
        return view('teacher.examform.examform', compact('subjects', 'classes', 'examform'));
    }

    

}
