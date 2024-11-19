<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    // @desc Get all users bookmarks
    // @route GET /bookmarks   
    public function index(): View
    {
        $user = Auth::user();

        $bookmarks = $user->bookmarkedByJobs()->orderBy("created_at","desc")->paginate(10);
        return view("jobs.bookmarked")->with("bookmarks", $bookmarks);
    }
}
