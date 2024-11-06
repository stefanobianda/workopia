<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // @desc Show registration form
    // @route GET /register
    public function register(): View
    {
        return view('auth.register');
    }
}
