<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\CourseModel; // Updated reference to the model's namespace

class StudentCourseController extends Controller
{
    public function index()
    {
        $courses = CourseModel::all(); // Fetch all courses
        return view('student.courses.courses', compact('courses'));
    }
}

