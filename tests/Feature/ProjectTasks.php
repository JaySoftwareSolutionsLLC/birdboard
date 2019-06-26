<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectTasks extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        //$this->withoutExceptionHandling(); // In tests it's typically a good idea to remove the nice way Laravel handles exceptions
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        // Alternative method:
        // $project = auth()->user()->projects()->create(
        //    factory(Project::class)->raw();
        //);
        
        $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $attributes = factory('App\Task')->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

}
