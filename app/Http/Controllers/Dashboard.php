<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Event;
use App\HumiditySensor;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', ['events' => Event::all(), 'sensors'=> HumiditySensor::all()]);
    }

    public function publish($message) {
        Redis::publish('pwire-server', $message);
    }
}
