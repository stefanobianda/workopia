<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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

        $bookmarks = $user->bookmarkedByJobs()->orderBy("job_user_bookmarks.created_at","desc")->paginate(10);
        return view("jobs.bookmarked")->with("bookmarks", $bookmarks);
    }

    // @desc Create new bookmarked job
    // @route Post /bookmarks{id}   
    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        // Check if the job is already bookmarked
        if ($user->bookmarkedByJobs()->where('job_id', $job->id)->exists()) {
            return back()->with('status', 'Job is already bookmarked');
        }

        // Create a new bookmark
        $user->bookmarkedByJobs()->attach($job->id);
        return back()->with('success','Job bookmarked succesfully');
    }
}
