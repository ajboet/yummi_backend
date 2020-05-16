<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * List Products feature test.
     *
     * @return void
     */
    public function testProductIndex()
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->getJson('/api/product');

        $res->assertStatus(200);
    }

    /**
     * Specific Product feature test.
     *
     * @return void
     */
    public function testProductShow()
    {
        $res = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])
        ->getJson('/api/product/4');

        $res->assertStatus(200);
    }
}
