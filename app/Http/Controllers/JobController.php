<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    use AuthorizesRequests;

    // @desc Show all job listings
    // @route GET /jobs    
    public function index(): View
    {
        $jobs = Job::paginate(3);
        return view('jobs.index')->with('jobs', $jobs);
        //        return view('jobs.index', compact('title', 'jobs'));
    }

    // @desc Show create job form
    // @route GET /jobs/create    
    public function create(): View
    {
        return view('jobs.create');
    }

    // @desc Save job to database
    // @route POST /jobs    
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url',
        ]);

        // Hardcoded user ID, will be updated later with auth implemented!
        $validatedData['user_id'] = 1;

        // Check for image
        if ($request->hasFile('company_logo')) {
            // Store the file
            $path = $request->file('company_logo')->store('logos', 'public');
            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }

        Job::create($validatedData);

        return redirect()->route('jobs.index')->with('success', 'Job listing created successfully!');
    }

    // @desc Show a single job listing
    // @route GET /jobs/{$id}
    public function show(Job $job): View
    {
        return view('jobs.show')->with('job', $job);
    }

    // @desc Show edit job form
    // @route GET /jobs/{$id}/edit
    public function edit(Job $job): View
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        return view('jobs.edit')->with('job', $job);
    }

    // @desc Update job listing
    // @route PUT /jobs/{$id}  
    public function update(Request $request, Job $job): RedirectResponse
    {
        // Check if user is authorized
        $this->authorize('update', $job);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255|min:5',
            'description' => 'required|string',
            'salary' => 'required|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'required|boolean',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zipcode' => 'nullable|string',
            'contact_email' => 'required|string',
            'contact_phone' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'nullable|url',
        ]);

        // Check for image
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            Storage::delete('public/logos/' . basename($job->company_logo));
            // Store the file
            $path = $request->file('company_logo')->store('logos', 'public');
            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }

        $job->update($validatedData);

        return redirect()->route('jobs.show', $job)->with('success', 'Job listing updated successfully!');
    }

    // @desc delete a job listing
    // @route DELETE /jobs/{$id}    
    public function destroy(Job $job): RedirectResponse
    {
        // Check if user is authorized
        $this->authorize('delete', $job);

        if ($job->company_logo) {
            // Delete old logo
            Storage::delete('public/logos/' . basename($job->company_logo));
        }

        $job->delete();

        if (request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing deleted successfully!');
        }
        return redirect()->route('jobs.index')->with('success', 'Job listing deleted successfully!');
    }
}
