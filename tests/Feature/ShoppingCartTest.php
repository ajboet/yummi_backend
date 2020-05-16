<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShoppingCartTest extends TestCase
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
        ->postJson('/api/order/add/4');

        $res->assertStatus(200);
    }

    /**
     * Show Order Totals and Items feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testShowOrder(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->getJson('/api/order');

        $res->assertStatus(200);
    }

    /**
     * Increment Order Item feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testIncrementOrderItem(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->postJson('/api/order/item/increment', [
            'cartItemIndex' => 0
        ]);

        $res->assertStatus(200);
    }

    /**
     * Decrement Order Item feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testDecrementOrderItem(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->postJson('/api/order/item/decrement', [
            'cartItemIndex' => 0
        ]);

        $res->assertStatus(200);
    }

    /**
     * Remove Order Item feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testRemoveOrderItem(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->postJson('/api/order/item/remove', [
            'cartItemIndex' => 0
        ]);

        $res->assertStatus(200);
    }

    /**
     * Delete Order feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testDeleteOrder(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->deleteJson('/api/order/delete');

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully deleted shopping cart.'
            ]);
    }

    /**
     * SignOut User feature test.
     *
     * @depends testUserSignIn
     * @return void
     */
    public function testUserSignOut(array $stack)
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$stack['token']
        ])
        ->getJson('/api/logout');

        $res->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out.'
            ]);
    }
}
