<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\PeriodModel; // Updated reference to the model's namespace

class TeacherPeriodController extends Controller
{
    // Display the list of periods
    public function index()
    {
        $periods = PeriodModel::all(); // Fetch all periods
        return view('teacher.periods.periods', compact('periods'));
        dd($periods->count());
    }
}

