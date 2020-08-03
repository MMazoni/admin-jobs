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
        $request->validate([
            'company_name' => 'required',
            'description' => 'required'
        ]);
        //dd($request->request);
        Job::create($request->all());
    }
}
