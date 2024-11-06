<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\View\View;

class HomeController extends Controller
{
    // @desc Show index/home page
    // @route GET /    
    public function index(): View
    {
        $jobs = Job::latest()->limit(3)->get();
        return view('pages.index')->with('jobs', $jobs);
    }
}
