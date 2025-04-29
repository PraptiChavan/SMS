<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'asc')->get();
        return view('admin.events.events', compact('events'));
    }
}
