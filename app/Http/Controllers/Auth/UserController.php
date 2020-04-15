<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __construct () {
        $this->middleware('auth');
    }

    public function index(User $user) {
        return view('auth.changePassword');
    }

    public function store(ChangePasswordRequest $request, User $user) {

    }
}
