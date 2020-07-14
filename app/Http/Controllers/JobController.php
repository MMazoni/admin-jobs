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

    public function store()
    {
        Job::create(request([
            'company_name', 'description', 'role', 'level',
            'requirements', 'location', 'benefits'
        ]));
    }
}
