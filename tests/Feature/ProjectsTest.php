<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase; // Adding withFaker allows us to add names, paragraphs, sentences, etc.
                                    // Adding RefreshDatabase rolls back any posted/updated/deleted values

    /** @test */ // <-- test will not run without whatever this is?

    // Create a test to verify that users can create projects
    public function a_user_can_create_a_project() {
        $this->withoutExceptionHandling(); // In tests it's typically a good idea to remove the nice way Laravel handles exceptions

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];
        
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);

    }

    /** @test */
    public function a_project_requires_a_title() {
        $this->withExceptionHandling();
        $attributes = factory('App\Project')->raw(['title' => '']); // Use factory to generate an example project in raw form (array not object that is not persisted in DB). Then set the title manually to an empty string. 
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description() {
        $this->withExceptionHandling();
        $attributes = factory('App\Project')->raw(['description' => '']); 
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
