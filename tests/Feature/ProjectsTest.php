<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase; // Adding withFaker allows us to add names, paragraphs, sentences, etc.
                                    // Adding RefreshDatabase rolls back any posted/updated/deleted values

    
    /** @test */
    public function guests_may_not_create_projects() {
        //$this->withExceptionHandling();
        $attributes = factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
        
    }

    /** @test */
    public function guests_may_not_view_projects() {
        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_may_not_view_a_single_project() {
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login');
    }
    
    /** @test */ // <-- test will not run without whatever this is?
    public function a_user_can_create_a_project() {
        $this->withoutExceptionHandling(); // In tests it's typically a good idea to remove the nice way Laravel handles exceptions
        $this->actingAs(factory('App\User')->create());
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }
    
    
    /** @test */
    public function a_user_can_view_their_project() {
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        //$this->post('/projects', $project);
    
        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others() {
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->withExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['title' => '']); // Use factory to generate an example project in raw form (array not object that is not persisted in DB). Then set the title manually to an empty string. 
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->withExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']); 
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


}
