<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StorePlatformSettingsRequest;
use App\Settings;
use App\Jobs\SetLogLevel;

class PlatformController extends Controller
{
    public function index() {
        return view('platform-settings', ['loglevel' => Settings::find('loglevel')->value]);
    }

    public function store(StorePlatformSettingsRequest $request) {
        $loglevel = Settings::find('loglevel');
        $loglevel->value = $request->loglevel;
        $loglevel->save();

        SetLogLevel::dispatch($loglevel->value);
        return redirect()->back()->with('success', [__('validation.saved', ['attribute' => 'Log Level'])]);
    }
}
