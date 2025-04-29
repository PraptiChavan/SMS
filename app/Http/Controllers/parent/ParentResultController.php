<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\admin\ResultModel;
use App\Models\admin\Student;
use App\Models\admin\ExamForm;
use App\Models\admin\SubjectModel;
use App\Models\admin\Account;

class ParentResultController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $parent = Account::find($userId);

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        // Fetch students linked to the parent
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_name', $parent->name)
            ->orWhere('mother_name', $parent->name)
            ->get(['id', 'name', 'classes']);

        return view('parent.results.results', compact('students'));
    }

    public function fetchResults(Request $request)
    {
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json(['status' => 'error', 'message' => 'No student selected']);
        }

        $student = Student::find($studentId);
        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found']);
        }

        // Fetch results based on student’s class
        $results = ResultModel::where('student_name', $student->name)
            ->get();

        if ($results->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No results found for this student']);
        }

        $formattedResults = $results->map(function ($result) {
        $examName = ExamForm::where('id', $result->exam_name)->value('name');
            return [
                'exam_name' => $examName,
                'student_name' => $result->student_name,
                'result_url' => asset('storage/' . $result->results),
            ];
        });

        return response()->json(['status' => 'success', 'data' => $formattedResults]);
    }
}
