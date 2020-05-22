<?php

namespace Tests\Feature;
use Tests\TestCase;

class UserSettingsTest extends TestCase
{

    /** @test */
    public function userSettingsRedirectsToLogin()
    {
        $response = $this->get('/user/1');
        $response->assertRedirect('/login');
    }


    /** @test */
    public function userSettingsCannotBeSafedIfNotLoggedIn()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com']);

        $response
            ->assertStatus(401);
    }
}
