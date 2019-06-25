<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    
    public function index() {
        //$projects = Project::all();
        $projects = auth()->user()->projects; // user can only see their projects
        //dd($projects);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project) {
        if (auth()->user()->isNot($project->owner)) {
           abort(403);
        }
        // not needed because we switched to use route:model binding above as a parameter $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));
    }

    public function store() {
        //dd('here');
        // validate
        $attributes = request()->validate([
            'title' => 'required'
            ,'description' => 'required'
            ]);
        //$attributes['owner_id'] = auth()->id();
        //dd($attributes);
        auth()->user()->projects()->create($attributes);
        //mail(auth()->user()->email, 'New Project Created', 'Congratulations ' . auth()->user()->name . '! You created a project.');
        // persist
        //Project::create($attributes);
        // redirect
        return redirect('/projects');
    }

    public function create() {
        return view('projects.create');
    }


}
