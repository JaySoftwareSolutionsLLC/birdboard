<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase; // Adding withFaker allows us to add names, paragraphs, sentences, etc.
                                    // Adding RefreshDatabase rolls back any posted/updated/deleted values

    
    /** @test */
    public function guests_may_not_manage_projects() {
        //$this->withExceptionHandling();
        //$attributes = factory('App\Project')->raw();
        $project = factory('App\Project')->create();
        
        // Typically one assertion per test is the standard. However, sometimes it makes sense to group common functionality together
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }
    
    /** @test */ // <-- test will not run without whatever this is?
    public function a_user_can_create_a_project() {
        $this->withoutExceptionHandling(); // In tests it's typically a good idea to remove the nice way Laravel handles exceptions
        $this->signIn();
        $this->get('/projects/create')->assertStatus(200); // We assume the page should load at this endpoint
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence(3),
            'notes' => 'General notes here.'
        ];
        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
            
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = [ 'notes' => 'New notes' ])
            ->assertRedirect($project->path());
        
        // Verify that project has been updated in database
        $this->assertDatabaseHas('projects', $attributes);
        // Verify that project is displaying updated notes in show page
        $this->get($project->path())->assertSee('New notes');
    }    
    
    /** @test */
    public function a_user_can_view_their_project() {
        $project = ProjectFactory::create();
        /*
        $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        */
        //$this->post('/projects', $project);
    
        $this->actingAs($project->owner)->get($project->path())->assertSee($project->title)->assertSee(str_limit($project->description, 55));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others() {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others() {
        $this->signIn();
        $project = factory('App\Project')->create();
        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->withExceptionHandling();
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']); // Use factory to generate an example project in raw form (array not object that is not persisted in DB). Then set the title manually to an empty string. 
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->withExceptionHandling();
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']); 
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


}
