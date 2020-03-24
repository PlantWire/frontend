<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', ['events' => Event::all()]);
    }
}
