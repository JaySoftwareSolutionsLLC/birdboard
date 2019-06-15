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
}
