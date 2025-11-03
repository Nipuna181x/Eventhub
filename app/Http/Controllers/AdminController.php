<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class AdminController extends Controller
{
    public function dashboard(){
        $recentEvents = Event::latest()->take(5)->get();
        return view('admin.dashboard', compact('recentEvents'));
    }
}
