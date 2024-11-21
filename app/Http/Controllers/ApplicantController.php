<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    // @desc Store new job application
    // route POST /jobs/{job}/apply
    public function store(Request $request, Job $job): RedirectResponse {
        // Check if the user has already applied
        $existingApplication = Applicant::where("job_id", $job->id)->where('user_id', auth()->id())->exists(); 
        if ($existingApplication) {
            return redirect()->back()->with('error','You have already applied to this job');
        }

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

    // @desc Delete job applicant
    // route DELETE /applicants/{applicant}
    public function destroy($id): RedirectResponse
    {
        $applicant = Applicant::findOrFail($id);

        // Delete resume
        if ($applicant->resume_path) {
            if (Storage::disk('public')->exists($applicant->resume_path)) {
                Storage::disk('public')->delete($applicant->resume_path);
            }
        }

        $applicant->delete();

        return redirect()->route('dashboard')->with('success','Applicant deleted successfully');
    }
}
