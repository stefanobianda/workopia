<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    // @desc Show login form
    // @route GET /login
    public function login(): View
    {
        return view('auth.login');
    }
}
