<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function loginIsLoaded()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function loginIsShown()
    {
        $this->get('/login')
            ->assertSee('Login')
            ->assertDontSee('Log out');
    }

}
