<?php

namespace App\Http\Controllers\parent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\Account;
use App\Models\admin\Student;

class ParentProfileController extends Controller
{
    public function index()
    {
        // Get the logged-in parent's ID from the session
        $userId = Session::get('user_id');

        // Fetch the parent's account details
        $parent = Account::where('id', $userId)->first();

        if (!$parent) {
            return redirect()->back()->with('error', 'Parent account not found');
        }

        // Fetch students whose details match the parent's email or mobile
        $students = Student::where('father_email', $parent->email)
            ->orWhere('mother_email', $parent->email)
            ->orWhere('father_mobile', $parent->name)
            ->orWhere('mother_mobile', $parent->name)
            ->pluck('name')
            ->toArray();

        // Convert student names to a comma-separated string
        $children = !empty($students) ? implode(', ', $students) : 'No Students Assigned';

        // Fetch student details where either father's or mother's email matches
        $parentData = Student::where('father_email', $parent->email)
                            ->orWhere('mother_email', $parent->email)
                            ->first();

        if (!$parentData) {
            return redirect()->back()->with('error', 'Parent details not found');
        }

        // Determine if the logged-in parent is the father or mother
        if ($parentData->father_email === $parent->email) {
            // Logged-in parent is the father
            $parentName = $parentData->father_name;
            $parentMobile = $parentData->father_mobile;
        } elseif ($parentData->mother_email === $parent->email) {
            // Logged-in parent is the mother
            $parentName = $parentData->mother_name;
            $parentMobile = $parentData->mother_mobile;
        } else {
            $parentName = 'N/A';
            $parentMobile = 'N/A';
        }

        // Fetch address details
        $parentAddress = $parentData->parents_address;
        $parentState = $parentData->parents_state;
        $parentCountry = $parentData->parents_country;
        $parentZip = $parentData->parents_zip;

        return view('parent.profile.profile', compact(
            'parent', 'children', 'parentName', 'parentMobile', 'parentAddress', 'parentState', 'parentCountry', 'parentZip'
        ));
    }
}


