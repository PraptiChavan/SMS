<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller;
use App\Models\admin\Account;
use App\Models\admin\Student;
use App\Models\admin\Section;
use App\Models\admin\PeriodModel;
use App\Models\admin\Attendance; // Import Attendance model
use Carbon\Carbon;

class ParentAttendanceController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');
        $parent = Account::find($userId);

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        // Fetch students belonging to the logged-in parent
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_name', $parent->name)
            ->orWhere('mother_name', $parent->name)
            ->get(['id', 'name', 'classes', 'sections']);

        $periods = PeriodModel::where('id', '!=', 5)->get();
        $totalPeriods = $periods->count();

        $today = Carbon::now();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        return view('parent.attendance.attendance', compact('students', 'periods', 'currentMonth', 'currentYear', 'totalPeriods'));
    }

    public function getAttendanceData(Request $request, $studentId)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        if (!$studentId) {
            return response()->json([]);
        }

        // Fetch attendance records
        $attendanceData = Attendance::where('student_id', $studentId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get(['date', 'period_id', 'status']);

        // Process data to get present periods per date
        $attendanceSummary = [];
        foreach ($attendanceData as $record) {
            $day = Carbon::parse($record->date)->day;

            if (!isset($attendanceSummary[$day])) {
                $attendanceSummary[$day] = ['present_periods' => 0];
            }

            if ($record->status === 'P') {
                $attendanceSummary[$day]['present_periods']++;
            }
        }

        return response()->json($attendanceSummary);
    }
}
