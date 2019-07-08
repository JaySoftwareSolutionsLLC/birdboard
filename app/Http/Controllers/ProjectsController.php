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
        $this->authorize('update', $project);
        // not needed because we switched to use route:model binding above as a parameter $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));
    }

    public function store() {
        //dd('here');
        // validate
        $attributes = request()->validate([
            'title' => 'required'
            ,'description' => 'required|max:100'
            ,'notes' => 'min:3' // Must have at least 3 characters
            ]);
        //$attributes['owner_id'] = auth()->id();
        //dd($attributes);
        $project = auth()->user()->projects()->create($attributes);
        //mail(auth()->user()->email, 'New Project Created', 'Congratulations ' . auth()->user()->name . '! You created a project.');
        // persist
        //Project::create($attributes);
        // redirect
        return redirect($project->path());
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update([
            'notes' => request('notes')
        ]);
        // Can also do this like this: $project->update(request(['notes']));
        return redirect($project->path());

    }

    public function create() {
        return view('projects.create');
    }


}
