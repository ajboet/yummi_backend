<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderRecordTest extends TestCase
{
    /**
     * SignIn User feature test.
     *
     * @return array $stack
     */
    public function testUserSignIn()
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->postJson('/api/login', [
            'email' => 'test@mail.com',
            'password' => 'abcd1234',
        ]);

        $stack = ['token' => $res['token']];

        $res->assertStatus(200);

        return $stack;
    }

    /**
     * Add given Product to Order feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testAddProductToOrder(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->postJson('/api/order/add/1');

        $res->assertStatus(200);
    }

    /**
     * Confirm Order Record feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testConfirmOrder(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->postJson('/api/confirm_order');

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully confirmed order.'
            ]);
    }

    /**
     * List User Order Record feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testOrderRecordIndex(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->getJson('/api/order_record');

        $res->assertStatus(200);
    }
}
