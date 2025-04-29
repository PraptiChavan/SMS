<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\SubjectModel;
use App\Models\admin\ClassModel;
use App\Models\admin\Section;
use App\Models\admin\Student;
use App\Models\admin\Account;

class ParentSubjectController extends Controller
{
    public function index()
    {
        // Get the logged-in parent's ID from the session
        $userId = Session::get('user_id');
        $parent = Account::where('id', $userId)->first();

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        // Fetch students whose details match the parent's email or mobile
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_mobile', $parent->name)
            ->orWhere('mother_mobile', $parent->name)
            ->get(['id', 'name', 'classes']);

        $subjects = [];
        $classes = ClassModel::all();
        $sections = Section::all();

        return view('parent.subjects.subjects', compact('students', 'subjects', 'classes', 'sections'));
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

    public function getSubjectsByStudent($studentId)
    {
        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $studentSectionId = $student->sections; // Get student's section ID

        $subjects = SubjectModel::where('classes', $student->classes)->get();

        foreach ($subjects as $subject) {
            $class = ClassModel::find($subject->classes);
            $subject->classTitle = $class->title ?? 'N/A';

            $sectionIds = explode(',', $subject->sections);
            $subject->sectionTitles = in_array($studentSectionId, $sectionIds)
                ? Section::where('id', $studentSectionId)->pluck('title')->toArray()
                : ['N/A'];
        }

        return response()->json($subjects);
    }



}

