<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;
use App\Models\admin\SubjectModel;
use App\Models\admin\TimeModel;
use App\Models\admin\WeekdayModel;
use App\Models\admin\Account;
use App\Models\admin\PeriodModel;

class TimeController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $periods = PeriodModel::where('id', '!=', 5)->get(); // Exclude the fifth period
        $weekdays = WeekdayModel::all();
        $accounts = Account::where('type', 'teacher')->get();
        // Retrieve all time entries
        $time = TimeModel::all();
        
        // Pass time entries to the view
        return view('admin.time-table.tt', compact('time', 'classes', 'sections', 'periods', 'weekdays', 'accounts'));
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

    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $periods = PeriodModel::where('id', '!=', 5)->get(); // Exclude the fifth period
        $accounts = Account::where('type', 'teacher')->get();
        $subjects = SubjectModel::all();
        $weekdays = WeekdayModel::all();

        return view('admin.time-table.create', compact('classes', 'sections', 'periods', 'accounts', 'subjects', 'weekdays'));
    }

    public function store(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'req_classes' => 'required',
            'req_sections' => 'required',
            'req_teachers' => 'required',
            'req_subjects' => 'required',
            'req_periods' => 'required',
            'req_weekdays' => 'required',
        ]);

        // Check if the teacher is already assigned for the selected period, weekday, class, and section
        $existingSchedule = TimeModel::where('teachers', $request->req_teachers)
            ->where('periods', $request->req_periods)
            ->where('weekdays', $request->req_weekdays)
            ->where('classes', $request->req_classes)
            ->where('sections', $request->req_sections)
            ->first();

        if ($existingSchedule) {
            // If a conflict exists, return an error response
            return response()->json(['error' => 'The teacher is already assigned for this period in the same class and section.'], 400);
        }

        // If no conflict, create the new timetable entry
        $time = new TimeModel();
        $time->classes = $request->req_classes;
        $time->sections = $request->req_sections;
        $time->teachers = $request->req_teachers;
        $time->subjects = $request->req_subjects;
        $time->periods = $request->req_periods;
        $time->weekdays = $request->req_weekdays;
        $time->save();

        // Redirect with success message
        return redirect()->route('admin.time-table')->with('success', 'Time table entry added successfully!');
    }

    public function filterTimeTable(Request $request)
    {
        $classId = $request->class_id;
        $sectionId = $request->section_id;

        // Fetch time entries filtered by class and section
        $filteredTime = TimeModel::where('classes', $classId)
            ->where('sections', $sectionId)
            ->get();

        $filteredTime->transform(function ($entry) {
            $entry->teachers = Account::whereIn('id', explode(',', $entry->teachers))->pluck('name')->toArray();
            $entry->subjects = SubjectModel::whereIn('id', explode(',', $entry->subjects))->pluck('name')->toArray();
            return $entry;
        });    

        return response()->json($filteredTime);
    }

    public function filterTimeTableByTeacher(Request $request)
    {
        $teacherId = $request->teacher_id;

        // Fetch time entries where the teacher is assigned
        $filteredTime = TimeModel::whereRaw("FIND_IN_SET(?, teachers)", [$teacherId])->get();

        // Transform the data to include class, section, and subjects names
        $filteredTime->transform(function ($entry) {
            $entry->class_title = ClassModel::find($entry->classes)?->title ?? 'No Class';
            $entry->section_title = Section::find($entry->sections)?->title ?? 'No Section';
            $entry->subjects = SubjectModel::whereIn('id', explode(',', $entry->subjects))->pluck('name')->toArray();
            return $entry;
        });

        return response()->json($filteredTime);
    }

    public function edit($id)
    {
        $entry = TimeModel::findOrFail($id);
        $classes = ClassModel::all();
        $sections = Section::all();
        $periods = PeriodModel::where('id', '!=', 5)->get();
        $accounts = Account::where('type', 'teacher')->get();
        $subjects = SubjectModel::all();
        $weekdays = WeekdayModel::all();
    
        return view('admin.time-table.edit', compact('entry', 'classes', 'sections', 'periods', 'accounts', 'subjects', 'weekdays'));
    }

    public function checkTeacherAvailability(Request $request)
    {
        $exists = TimeModel::where('teachers', $request->teacher_id)
            ->where('periods', $request->period_id)
            ->where('weekdays', $request->weekday_id)
            ->where('id', '!=', $request->entry_id) // Exclude current entry being edited
            ->exists();
    
        return response()->json(['exists' => $exists]);
    }    

    public function update(Request $request, $id)
    {
        $request->validate([
            'req_classes' => 'required',
            'req_sections' => 'required',
            'req_teachers' => 'required',
            'req_subjects' => 'required',
            'req_periods' => 'required',
            'req_weekdays' => 'required',
        ]);

        // Check if the teacher is already assigned for the same period and weekday in another entry
        $existingSchedule = TimeModel::where('teachers', $request->req_teachers)
            ->where('periods', $request->req_periods)
            ->where('weekdays', $request->req_weekdays)
            ->where('id', '!=', $id) // Exclude current entry being updated
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with('error', 'This teacher is already assigned for this period on the same weekday.');
        }

        $entry = TimeModel::findOrFail($id);
        $entry->classes = $request->req_classes;
        $entry->sections = $request->req_sections;
        $entry->teachers = $request->req_teachers;
        $entry->subjects = $request->req_subjects;
        $entry->periods = $request->req_periods;
        $entry->weekdays = $request->req_weekdays;
        $entry->save();

        return redirect()->route('admin.time-table')->with('success', 'Timetable updated successfully!');
    }
    
    public function destroy($id)
    {
        $entry = TimeModel::findOrFail($id);
        $entry->delete();

        return response()->json(['success' => 'Timetable entry deleted successfully.']);
    }

}
