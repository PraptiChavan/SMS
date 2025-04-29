<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;
use App\Models\admin\SubjectModel;
use App\Models\admin\TimeModel;
use App\Models\admin\WeekdayModel;
use App\Models\admin\PeriodModel;
use App\Models\admin\Account;
use App\Models\admin\Student;

class ParentTimeController extends Controller
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
            ->get(['id', 'name', 'classes', 'sections']);

        $periods = PeriodModel::where('id', '!=', 5)->get();
        $weekdays = WeekdayModel::all();

        return view('parent.time-table.tt', compact('students', 'periods', 'weekdays'));
    }

    public function filterTimeTable(Request $request)
    {
        $studentId = $request->student_id;
        $studentClass = $request->class_id;
        $studentSection = $request->section_id;

        $filteredTime = TimeModel::where('classes', $studentClass)
            ->where('sections', $studentSection)
            ->get();

        $filteredTime->transform(function ($entry) {
            $entry->teachers = Account::whereIn('id', explode(',', $entry->teachers))->pluck('name')->toArray();
            $entry->subjects = SubjectModel::whereIn('id', explode(',', $entry->subjects))->pluck('name')->toArray();
            return $entry;
        });

        return response()->json($filteredTime);
    }
}


