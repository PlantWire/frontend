<?php

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\ImpersonatesUsers;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    protected $user;

    protected function login()
    {
        $this->user = factory(User::class)->create([
            'id' => 1,
            'name' => 'Sr. Catson',
            'email' => 'pwire@pwire.com',
            'password' => bcrypt($password = 'password1!'),
        ]);

        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => $password,
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/');
        $this->assertAuthenticatedAs($this->user);
    }

    protected function logout()
    {
        $response = $this->withHeaders([
                    'X-Header' => 'Value',
                ])->json('POST', '/logout', []);

        $this->assertGuest();
    }
}
