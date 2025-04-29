<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\SubjectModel; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;

class StudentSubjectController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::all(); // Fetch all courses
        $classes = ClassModel::all();   // Fetch all classes
        $sections = Section::all();     // Fetch all sections
        foreach ($subjects as $subject) {
            // Get the class ID
            $classId = $subject->classes;
    
            // Find the corresponding class title
            $class = ClassModel::find($classId);
            $subject->classTitle = $class->title ?? 'N/A'; 
    
            // Get section titles (if any)
            $sectionIds = explode(',', $subject->sections);
            $subject->sectionTitles = Section::whereIn('id', $sectionIds)->pluck('title')->toArray(); 
        }
        return view('student.subjects.subjects', compact('subjects', 'classes', 'sections'));
    }
    public function getSectionsByClass($classId)
    {
        $class = ClassModel::find($classId);
        if ($class) {
            $sectionIds = explode(',', $class->sections);
            $sections = Section::whereIn('id', $sectionIds)->pluck('title', 'id');
            return response()->json($sections);
        }
        return response()->json([]);
    }
}

