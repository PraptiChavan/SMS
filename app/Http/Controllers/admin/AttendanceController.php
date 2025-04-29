<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Not actually necessary for the Admin part
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel;
use App\Models\admin\Section;
use App\Models\admin\PeriodModel;
use App\Models\admin\Student;
use App\Models\admin\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $students = Student::all();
        $periods = PeriodModel::where('id', '!=', 5)->get();

        // Get current month and year
        $today = Carbon::now();
        $currentMonth = $today->month;
        $currentYear = $today->year;
        $daysInMonth = $today->daysInMonth; // Total days in current month

        return view('admin.attendance.attendance', compact('classes', 'sections', 'students', 'periods', 'daysInMonth', 'currentMonth', 'currentYear'));
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
    
    public function getStudentsByClassAndSection($classId, $sectionId)
    {
        $students = Student::where('classes', $classId)
                        ->where('sections', $sectionId)
                        ->get(['id', 'name']);

        return response()->json($students);
    }

    public function getAttendanceData($classId, $sectionId, Request $request) 
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $periodId = $request->query('period_id');

        $attendance = Attendance::whereHas('student', function ($query) use ($classId, $sectionId) {
                $query->where('classes', $classId)->where('sections', $sectionId);
            })
            ->where('period_id', $periodId) // Filter by period
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'ASC') // Ensure chronological order
            ->get(['period_id', 'student_id', 'date', 'status']);

        return response()->json($attendance->map(function ($record) {
            return [
                'period_id'=> $record->period_id,
                'student_id' => $record->student_id,
                'day' => Carbon::parse($record->date)->day,
                'status' => $record->status
            ];
        }));
    }

    
    public function saveAttendance(Request $request) 
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.day' => 'required|integer|min:1|max:31',
            'attendance.*.status' => 'required|in:P,A',
            'year' => 'required|integer',
            'month' => 'required|integer|min:1|max:12',
            'period_id' => 'required|exists:periods,id',
        ]);

        foreach ($request->attendance as $entry) {
            $date = Carbon::create($request->year, $request->month, $entry['day'])->format('Y-m-d');

            Attendance::updateOrCreate(
                ['student_id' => $entry['student_id'], 'date' => $date, 'period_id' => $request->period_id],
                ['status' => $entry['status']]
            );
        }

        return response()->json(['message' => 'Attendance saved successfully!']);
    }


    
}

