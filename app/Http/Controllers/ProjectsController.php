<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Project;

class ProjectsController extends Controller
{
    /* T&V LU&R pg 34 | Adding middleware to at the controller rather than in a group of routes
    public function __construct()
    {
        $this->middleware('auth');
    }
    */
    
    public function index() {
        //$projects = Project::all();
        $projects = auth()->user()->projects; // user can only see their projects
        //dd($projects);
        // T&V LU&R pg60 | return response()->json($projects);
        return view('projects.index', compact('projects'));
        //T&V LU&R pg 41 | return view('projects.index')->with('projects', $projects);
        // LU&R pg 51 return view('projects.index');//->with('p', $projects);
    }

    public function show(Project $project) {
        $this->authorize('update', $project);
        // not needed because we switched to use route:model binding above as a parameter $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));
    }

    public function store() {
        // T&V LU&R pg 59 | abort_unless(auth()->user()->id == 2, 403);
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
        // T&V LU&R pg 57 | return redirect()->home();
        // T&V LU&R pg 57 | return redirect()->action('ProjectsController@index');
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
