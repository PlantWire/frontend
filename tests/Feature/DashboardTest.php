<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function dashboardIsLoaded()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function userIsLoggedOut()
    {
        $this->get('/')
            ->assertSee('Dashboard')
            ->assertSee('Log in')
            ->assertDontSee('Event Log')
            ->assertDontSee('User Settings')
            ->assertDontSee('Plattform Settings')
            ->assertDontSee('Log out');
    }


    /** @test */
    public function logoutIsOnlyOnStartPageIfLoggedIn()
    {
        $this->get('/')
            ->assertSee('Log in')
            ->assertDontSee('Log out');

        $this->login();
        $this->get('/')
            ->assertSee('Log out')
            ->assertDontSee('Log in');

        $this->logout();
        $this->get('/')
            ->assertSee('Log in')
            ->assertDontSee('Log out');
    }
}
