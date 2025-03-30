<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_logout_successfully()
    {
        $this->seed('UsersTableSeeder');
        
        $user = User::first();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertStatus(302);

        $this->assertGuest();

        $response->assertRedirect('/');
    }
}
