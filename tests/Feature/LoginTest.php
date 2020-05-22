<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{

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

    /** @test */
    public function loginIsNotLoadedIfLoggedIn()
    {
        $this->login();

        $response = $this->get('/login');
        $response->assertStatus(302)
            ->assertRedirect('/');
    }
}
