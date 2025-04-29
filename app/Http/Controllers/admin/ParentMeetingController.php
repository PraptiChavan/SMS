<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\ParentMeeting;
use App\Models\admin\Account;
use App\Models\admin\ClassModel;
use Illuminate\Support\Facades\DB;

class ParentMeetingController extends Controller {
    
    // Show meeting creation form
    public function index() {
        $teachers = Account::where('type', 'teacher')->get();
        $classes = ClassModel::all();
        return view('admin.meetings.create', compact('teachers', 'classes'));
    }

    // Store meeting (no student handling)
    public function store(Request $request) {
        try {
            $data = $request->all();

            // If it's an online meeting but no link is provided, set a placeholder
            if ($data['mode'] === 'Online' && empty($data['meeting_link'])) {
                $data['meeting_link'] = 'https://meet.example.com/default';
            }

            // Create the meeting
            ParentMeeting::create($data);

            return response()->json(['success' => 'Meeting scheduled successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Fetch meetings (optional, if needed later)
    public function fetchMeetings() {
        $meetings = ParentMeeting::all();
        return response()->json($meetings);
    }

    // Update status (Accept/Decline/Reschedule)
    public function updateStatus(Request $request, $id)
    {
        $meeting = ParentMeeting::findOrFail($id);

        $userId = Session::get('user_id'); // Admin ID
        $meeting->status = $request->status;
        $meeting->status_updated_by = $userId;
        $meeting->save();

        return response()->json(['success' => 'Status updated']);
    }


    public function getUpcomingMeetings(Request $request) {
        $classId = $request->input('class_id');
    
        $meetings = DB::table('parents_meetings')
            ->join('accounts', function ($join) {
                $join->on('parents_meetings.teacher_id', '=', 'accounts.id')
                    ->where('accounts.type', '=', 'teacher');
            })
            ->join('classes', 'parents_meetings.class_id', '=', 'classes.id')
            ->select(
                'parents_meetings.*',
                'accounts.name as teacher_name',
                'classes.title as class_title',
                'updated_by.name as updated_by_name',
                DB::raw("DATE_FORMAT(parents_meetings.time, '%H:%i') as formatted_time")
            )
            ->leftJoin('accounts as updated_by', 'parents_meetings.status_updated_by', '=', 'updated_by.id')
            ->where('parents_meetings.date', '>=', now()->toDateString());
    
        // Apply class filter if provided
        if (!empty($classId)) {
            $meetings->where('parents_meetings.class_id', $classId);
        }
    
        $meetings = $meetings->orderBy('parents_meetings.date', 'asc')
            ->orderBy('parents_meetings.time', 'asc')
            ->get();
    
        return response()->json($meetings);
    }
    
    public function getMeetings($classId) {
        $meetings = DB::table('parents_meetings')
            ->join('accounts', 'parents_meetings.teacher_id', '=', 'accounts.id')
            ->join('classes', 'parents_meetings.class_id', '=', 'classes.id')
            ->select(
                'parents_meetings.*',
                'accounts.name as teacher_name',
                'classes.title as class_title',
                'updated_by.name as updated_by_name',
                DB::raw("DATE_FORMAT(parents_meetings.time, '%H:%i') as formatted_time")
            )
            ->leftJoin('accounts as updated_by', 'parents_meetings.status_updated_by', '=', 'updated_by.id')            
            ->where('parents_meetings.class_id', $classId)
            ->where('parents_meetings.date', '>=', now()->toDateString())
            ->orderBy('parents_meetings.date', 'asc')
            ->orderBy('parents_meetings.time', 'asc')
            ->get();
    
        return response()->json($meetings);
    }
    

}