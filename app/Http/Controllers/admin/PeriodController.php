<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\PeriodModel; // Updated reference to the model's namespace

class PeriodController extends Controller
{
    // Display the list of periods
    public function index()
    {
        $periods = PeriodModel::all(); // Fetch all periods
        return view('admin.periods.periods', compact('periods'));
    }

    // Show the form to add a new period (optional, if needed)
    public function create()
    {
        return view('admin.periods.create');
    }

    // Store a new period in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i|after:from',
        ]);

        // Check if the period title already exists
        if (PeriodModel::where('title', $request->title)->exists()) {
            return response()->json(['error' => 'Period title already exists!'], 400);
        }

        // Check if a period with the same from and to time already exists
        if (PeriodModel::where('from', $request->from)->where('to', $request->to)->exists()) {
            return response()->json(['error' => 'The selected time period already exists!'], 400);
        }

        // Check for overlapping periods
        $overlappingPeriod = PeriodModel::where(function ($query) use ($request) {
            $query->where('from', '<', $request->to)
                ->where('to', '>', $request->from);
        })->exists();

        if ($overlappingPeriod) {
            return response()->json(['error' => 'The time period overlaps with an existing period!'], 400);
        }

        // If not exists, create the period
        $newPeriod = PeriodModel::create($validated);

        return response()->json([
            'success' => 'Period added successfully!',
            'newPeriod' => $newPeriod
        ]);
    }

    public function edit($id)
    {
        $periods = PeriodModel::findOrFail($id);

        return view('admin.periods.edit', compact('periods'));
    }

    public function update(Request $request, $id)
    {
        $periods = PeriodModel::findOrFail($id);
        $periods->update([
            'title' => $request->title,
            'from' => $request->from,
            'to' => $request->to,
        ]);
        return redirect()->route('admin.periods')->with('success', 'Periods updated successfully!');
    }

    public function destroy($id)
    {
        $periods = PeriodModel::findOrFail($id);
        $periods->delete();

        return redirect()->route('admin.periods')->with('success', 'Periods deleted successfully!');
    }
}
