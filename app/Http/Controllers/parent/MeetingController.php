<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\ParentMeeting;
use App\Models\admin\Account;
use App\Models\admin\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MeetingController extends Controller
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

        return view('parent.meetings.index', compact('students'));
    }

    public function getMeetingsForParent(Request $request)
    {
        $userId = Session::get('user_id');
        $parent = Account::where('id', $userId)->first();

        if (!$parent) {
            return response()->json(['status' => 'error', 'message' => 'Parent account not found']);
        }

        // Get all students of the parent
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_mobile', $parent->name)
            ->orWhere('mother_mobile', $parent->name)
            ->get();

        if ($students->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No students found']);
        }

        // Get unique class IDs from all the parent's students
        $classIds = $students->pluck('classes')->unique();

        // Fetch meetings for all those class IDs
        $meetings = DB::table('parents_meetings')
            ->join('accounts', 'parents_meetings.teacher_id', '=', 'accounts.id')
            ->join('classes', 'parents_meetings.class_id', '=', 'classes.id')
            ->select(
                'parents_meetings.*',
                'accounts.name as teacher_name',
                'classes.title as class_title',
                DB::raw("DATE_FORMAT(parents_meetings.time, '%H:%i') as formatted_time")
            )
            ->where('parents_meetings.date', '>=', now()->toDateString())
            ->whereIn('parents_meetings.class_id', $classIds)
            ->orderBy('parents_meetings.date', 'asc')
            ->orderBy('parents_meetings.time', 'asc')
            ->get();

        return response()->json($meetings);
    }

    public function updateStatus(Request $request, $id)
    {
        $userId = Session::get('user_id'); // Parent ID
        $parent = Account::where('id', $userId)->first();

        if (!$parent) {
            return response()->json(['status' => 'error', 'message' => 'Parent account not found']);
        }

        $meeting = ParentMeeting::find($id);

        $student = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->where('classes', $meeting->class_id)
            ->first();

        if (!$meeting || !$student) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized to update this meeting']);
        }

        // ✅ Update status + who updated it
        $meeting->status = $request->status;
        $meeting->status_updated_by = $userId;
        $meeting->save();

        return response()->json(['status' => 'success', 'message' => 'Meeting status updated successfully']);
    }


}
