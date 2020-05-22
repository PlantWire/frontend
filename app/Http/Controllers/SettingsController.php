<?php

namespace App\Http\Controllers;

use Redirect;
use Auth;
use App\Http\Requests\StoreSettingsRequest;

use App\Settings;

use App\Jobs\SetLogLevel;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index', ['loglevel' => Settings::find('loglevel')->value]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingsRequest $request)
    {
        $loglevel = Settings::find('loglevel');
        $loglevel->value = $request->loglevel;
        $loglevel->save();

        SetLogLevel::dispatch($loglevel->value);
        return Redirect::back()->with('success', [__('validation.saved', ['attribute' => 'Log Level'])]);
    }
}
