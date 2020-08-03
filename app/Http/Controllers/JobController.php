<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();

        return view('jobs.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        Job::create($request->all());
    }

    public function edit(Request $request, Job $job)
    {
        $this->validateRequest($request);
        $job->update($request->all());
    }

    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'company_name' => 'required',
            'description' => 'required'
        ]);
    }
}
