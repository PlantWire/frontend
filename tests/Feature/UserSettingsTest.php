<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserSettingsTest extends TestCase
{

    /** @test */
    public function userSettingsRedirectsToLogin()
    {
        $response = $this->get('/user/1/edit');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function userSettingsAccessibleIfLoggedIn()
    {
        $this->login();

        $response = $this->get('/user/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function userSettingsCannotBeOverwrittenIfNotLoggedIn()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com']);

        $response->assertStatus(401);
    }

    /** @test */
    public function userSettingsCanBeOverwrittenIfLoggedIn()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Mme. Dogdottir', 'email' => 'noresponse@pwire.com']);

        $response->assertStatus(302);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue('Mme. Dogdottir' === $this->user->name);
        $this->assertTrue('noresponse@pwire.com' === $this->user->email);
    }

    /** @test */
    public function userSettingsRequireName()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['email' => 'noresponse@pwire.com']);

        $response->assertStatus(422);
        //    ->assertSessionHas(['name' => 'The Name field is required.']);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue('pwire@pwire.com' === $this->user->email);
    }

    /** @test */
    public function userSettingsRequireEmail()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Mme. Dogdottir']);

        $response->assertStatus(422);
        //    ->assertSessionHas(['email' => 'The Email field is required.']);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue('Sr. Catson' === $this->user->name);
    }

    /** @test */
    public function passwordCanBeOverwrittenIfLoggedIn()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com',
            'old_password' => 'password1!', 'new_password' => 'Password2', 'new_password_confirmation' => 'Password2']);
        $response->assertStatus(302);

        $this->user = $this->user->find($this->user->id);
        $this->assertFalse(Hash::check('password1!', $this->user->password));
        $this->assertTrue(Hash::check('Password2', $this->user->password));
    }

    /** @test */
    public function userSettingsRequireNewPasswordAndNewPasswordConfirmationWithOldPassword()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com',
            'old_password' => 'password1!']);

        $response->assertStatus(422);
        //    ->assertSessionHas(['new_password' =>
        //    'The new password field is required when old password is present.'])
        //    ->assertSessionHas(['new_password_confirmation' =>
        //    'The new password confirmation field is required when old password is present.']);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue(Hash::check('password1!', $this->user->password));
    }

    /** @test */
    public function newPasswordAndNewPasswordConfirmationMustMatch()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com',
            'old_password' => 'password1!', 'new_password' => 'Password2', 'new_password_confirmation' => 'Password3']);

        $response->assertStatus(422);
        //    ->assertSessionHas(['new_password' =>
        //    'The new password confirmation does not match.']);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue(Hash::check('password1!', $this->user->password));
    }

    /** @test */
    public function newPasswordMustBeComplex()
    {
        $this->login();

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user/1', ['name' => 'Sr. Catson', 'email' => 'pwire@pwire.com',
            'old_password' => 'password1!', 'new_password' => 'password', 'new_password_confirmation' => 'password']);

        $response->assertStatus(422);
        //    ->assertSessionHas(['new_password' =>
        //    'Passwords must use at least three character types. Your password contained lowercase letters but not uppercase letters, numbers and symbols.']);

        $this->user = $this->user->find($this->user->id);
        $this->assertTrue(Hash::check('password1!', $this->user->password));
    }
}
