<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Event;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', ['events' => Event::all()]);
    }

    public function publish($message) {
        Redis::publish('pwire-server', $message);
    }
}
