<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\admin\AdmitModel;
use App\Models\admin\ClassModel;
use App\Models\admin\SubjectModel;
use App\Models\admin\Student;
use App\Models\admin\Account;

class ParentAdmitCardController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $parent = Account::find($userId);

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_name', $parent->name)
            ->orWhere('mother_name', $parent->name)
            ->get(['id', 'name', 'classes']);

        return view('parent.admitcard.admitcard', compact('students'));
    }

    public function fetchAdmitCards(Request $request)
    {
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json(['status' => 'error', 'message' => 'No student selected']);
        }

        // Fetch student details based on ID
        $student = Student::find($studentId);

        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found']);
        }

        // Now fetch admit cards using the student's NAME (not ID)
        $admitCards = AdmitModel::where('student_name', $student->name)->get();

        if ($admitCards->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No admit cards found for this student']);
        }

        // Format the admit card data for response
        $formattedCards = $admitCards->map(function ($card) {
            return [
                'student_name' => $card->student_name,
                'fees_paid' => $card->fees_paid,
                'admit_card_url' => asset('storage/' . $card->admit_card),
            ];
        });

        return response()->json(['status' => 'success', 'data' => $formattedCards]);
    }

}
