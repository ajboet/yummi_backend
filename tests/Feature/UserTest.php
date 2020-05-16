<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    /**
     * SignUp feature test.
     *
     * @return array $stack
     */
    public function testUserSignUp()
    {
        $stack = ['rand' => Str::random(4)];
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->postJson('/api/signup', [
            'name' => 'Test-'.$stack['rand'],
            'email' => 'test_'.$stack['rand'].'@mail.com',
            'password' => 'abcd1234',
            'password_confirmation' => 'abcd1234',
            'cellphone_number' => mt_rand(),
            'full_address' => 'Address'
        ]);

        $res->assertStatus(201)
            ->assertJson([
                'message' => 'Successfully registered user.'
            ]);

        return $stack;
    }

    /**
     * SignIn feature test.
     *
     * @depends testUserSignUp
     * @return array $stack2
     */
    public function testUserSignIn(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->postJson('/api/login', [
            'email' => 'test_'.$stack['rand'].'@mail.com',
            'password' => 'abcd1234',
        ]);

        $stack2 = ['token' => $res['token']];

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged in.',
            ]);

        return $stack2;
    }

    /**
     * Update User feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testUserUpdate(array $stack2)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack2['token']
        ])
        ->patchJson('/api/update', [
            'full_address' => 'New Address'
        ]);

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully updated user.'
            ]);
    }

    /**
     * SignOut User feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testUserSignOut(array $stack2)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack2['token']
        ])
        ->getJson('/api/logout');

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out.'
            ]);
    }
}
