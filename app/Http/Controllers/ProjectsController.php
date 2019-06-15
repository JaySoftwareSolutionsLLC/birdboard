<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    public function index() {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project) {
        // not needed because we switched to use route:model binding above as a parameter $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));
    }

    public function store() {
        // validate
        $attributes = request()->validate(['title' => 'required', 'description' => 'required']);
        // persist
        Project::create($attributes);
        // redirect
        return redirect('/projects');
    }


}
