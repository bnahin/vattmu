<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGuestRedirect()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }
}
