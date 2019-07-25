<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;

class ProjectTasksController extends Controller {
    public function store(Project $project) { // LU&R pg 47 | This method is using typehinting. This tells Laravel that $project is expected to be of type Project (from App\Project). This is what allows us to use it's Path method (as well as addTask)
        $this->authorize('update', $project);
        request()->validate(['body' => 'required']);
        $project->addTask(request('body'));
        return redirect($project->path());
    }
    public function update(Project $project, Task $task) {
        $this->authorize('update', $task->project);
        /*
        if (auth()->user()->isNot($task->project->owner)) {
            abort(403);
        }
        */
        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);
        return redirect($project->path());
    }
}