<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        // Create a user based on argument or newly generated user
        $user = $user ?: factory('App\User')->create();
        // Sign in to user
        $this->actingAs($user);
        // Return instance of this to allow class fluidity
        return $user;
    }
}
