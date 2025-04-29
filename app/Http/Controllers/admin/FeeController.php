<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\Student; // Updated reference to the model's namespace

class FeeController extends Controller
{
    public function index()
    {
        $students = Student::all();// Fetch all sections from the database
        return view('admin.student-fee.student_fee', compact('students'));
    }
}
