<?php

// This file is used to setup testing conditions more easily

namespace Tests\Setup;

use App\Project;
use App\User;
use App\Task;

class ProjectFactory // Project factory will be called from test pages to generate a task with an assigned owner, a set number of tasks
{
    // Default task count to zero
    protected $tasksCount = 0; 
    protected $user = null; 
    // Allow each instance to call withTasks to update the qty of tasks associated with project
    public function withTasks($count) 
    {
        $this->tasksCount = $count;
        return $this; // We need to return $this so that we can chain commands together? (fluent-ness?)
    }
    public function ownedBy($user)
    {
        $this->user = $user;
        return $this;
    }
    // Create project
    public function create() 
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class) // Dont need to do the whole path for this to work...Laravel for the win->create()->id;
        ]);
        // If tasks exist then create that many tasks and associate them with this project
        factory(Task::class, $this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

}