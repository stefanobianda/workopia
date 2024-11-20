<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    // @desc Store new job application
    // route POST /jobs/{job}/apply
    public function store(Request $request, Job $job): RedirectResponse {
        // Validate incoming data
        $validateData = $request->validate([
            "full_name" => "required|string",
            "contact_phone" => "nullable|string",
            "contact_email" => "required|string|email",
            "message" => "nullable|string",
            "location" => "nullable|string",
            "resume" => "required|file|mimes:pdf|max:2048",
        ]);

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validateData['resume_path'] = $path;
        }

        // Store the application
        $application = new Applicant($validateData);
        $application->job_id = $job->id;
        $application->user_id = auth()->id();
        $application->save();

        return redirect()->back()->with('success','Your application has been submitted');
    }
}
