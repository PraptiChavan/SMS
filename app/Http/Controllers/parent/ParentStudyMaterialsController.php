<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\StudyMaterials; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\SubjectModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class ParentStudyMaterialsController extends Controller
{
    public function index()
    {
        // Get the logged-in parent's ID from session
        $userId = Session::get('user_id');
        $parent = Account::find($userId);

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        // Fetch students linked to the parent (via email or name)
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_name', $parent->name)
            ->orWhere('mother_name', $parent->name)
            ->get(['id', 'name', 'classes']);

        return view('parent.studymaterials.studymaterials', compact('students'));
    }

    public function fetchStudyMaterials(Request $request)
    {
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json(['status' => 'error', 'message' => 'No student selected']);
        }

        // Get the selected student's class
        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found']);
        }

        // Fetch study materials for the student's class
        $studyMaterials = StudyMaterials::where('classes', $student->classes)->get();

        // Loop through study materials to get class and subject names
        $formattedMaterials = $studyMaterials->map(function ($material) {
            $classTitles = ClassModel::whereIn('id', explode(',', $material->classes))->pluck('title')->toArray();
            $subjectNames = SubjectModel::whereIn('id', explode(',', $material->subjects))->pluck('name')->toArray();

            return [
                'id' => $material->id,
                'title' => $material->title,
                'attachment' => $material->attachment,
                'classes' => implode(', ', $classTitles),
                'subjects' => implode(', ', $subjectNames),
                'date' => $material->date,
                'description' => $material->description,
            ];
        });

        return response()->json(['status' => 'success', 'data' => $formattedMaterials]);
    }
}
