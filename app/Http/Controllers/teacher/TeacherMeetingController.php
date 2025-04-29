<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\ParentMeeting;
use App\Models\admin\Account;
use App\Models\admin\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TeacherMeetingController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $teacher = Account::where('id', $userId)->first();

        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher account not found');
        }

        return view('teacher.meetings.index');
    }

    public function getMeetingsForTeacher()
    {
        $userId = Session::get('user_id');
        $teacher = Account::where('id', $userId)->first();

        if (!$teacher) {
            return response()->json(['status' => 'error', 'message' => 'Teacher account not found']);
        }

        $meetings = DB::table('parents_meetings')
            ->join('accounts', 'parents_meetings.teacher_id', '=', 'accounts.id')
            ->join('classes', 'parents_meetings.class_id', '=', 'classes.id')
            ->leftJoin('accounts as updater', 'parents_meetings.status_updated_by', '=', 'updater.id') // ✅ Join for updatedBy
            ->select(
                'parents_meetings.*',
                'accounts.name as teacher_name',
                'classes.title as class_title',
                'updated_by.name as updated_by_name',
                DB::raw("DATE_FORMAT(parents_meetings.time, '%H:%i') as formatted_time")
            )
            ->leftJoin('accounts as updated_by', 'parents_meetings.status_updated_by', '=', 'updated_by.id')
            ->where('parents_meetings.date', '>=', now()->toDateString())
            ->where('parents_meetings.teacher_id', $teacher->id)
            ->orderBy('parents_meetings.date', 'asc')
            ->orderBy('parents_meetings.time', 'asc')
            ->get();
        return response()->json($meetings);
    }

    public function updateStatus(Request $request, $id)
    {
        $userId = Session::get('user_id');
        $teacher = Account::where('id', $userId)->first();

        if (!$teacher) {
            return response()->json(['status' => 'error', 'message' => 'Teacher account not found']);
        }

        $meeting = ParentMeeting::find($id);

        if (!$meeting || $meeting->teacher_id != $teacher->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized to update this meeting']);
        }

        $meeting->status = $request->status;
        $meeting->status_updated_by = $teacher->id; // ✅ Track who updated
        $meeting->save();

        return response()->json(['status' => 'success', 'message' => 'Meeting status updated successfully']);
    }

}
