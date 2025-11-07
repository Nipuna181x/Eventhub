<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class UserController extends Controller
{
    public function dashboard(){
        // Provide the same recent events data as the admin dashboard so the view can render consistently
        $recentEvents = Event::latest()->take(5)->get();
        return view('user.dashboard', compact('recentEvents'));
    }
}
