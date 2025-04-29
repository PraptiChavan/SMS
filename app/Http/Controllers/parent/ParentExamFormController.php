<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\SubjectModel;
use App\Models\admin\ClassModel;
use App\Models\admin\ExamForm; // Updated reference to the model's namespace
use App\Models\admin\Student;
use App\Models\admin\Account;


class ParentExamFormController extends Controller
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

        return view('parent.examform.examform', compact('students'));
    }

    public function fetchExamForm(Request $request)
    {
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json(['status' => 'error', 'message' => 'No student selected']);
        }

        // Get the selected student and class
        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found']);
        }

        // Fetch exams for the student's class
        $examForms = ExamForm::where('classes', $student->classes)->get();

        // Format exam details
        $formattedExams = $examForms->map(function ($exam) {
            $classTitle = ClassModel::find($exam->classes)->title ?? 'No Class';
            $subjectNames = SubjectModel::whereIn('id', explode(',', $exam->subjects))->pluck('name')->toArray();

            return [
                'name' => $exam->name,
                'class' => $classTitle,
                'subjects' => implode(', ', $subjectNames),
                'date' => $exam->date,
                'start_time' => \Carbon\Carbon::parse($exam->start_time)->format('H:i'),
                'end_time' => \Carbon\Carbon::parse($exam->end_time)->format('H:i'),
                'total_marks' => $exam->total_marks,
            ];
        });

        return response()->json(['status' => 'success', 'data' => $formattedExams]);
    }

}
