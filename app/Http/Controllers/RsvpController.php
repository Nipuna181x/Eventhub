<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index()
    {
        return view('rsvp.rsvp');
    }
}
