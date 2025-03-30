<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_change_shipping_address()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);
    
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '山本　太郎',
        ]);
        $this->assertDatabaseHas('profiles', [
            'profile_user_id' => $user->id,
            'image' => 'banana.png',
            'postal' => '123-4567',
            'address' => '三重県伊勢市123番地',
            'building' => '石川アパート101号室'
        ]);

        $response = $this->get("/mypage/profile");
        $response->assertStatus(200);

        $response->assertSee('banana');
        $response->assertSee('山本　太郎');
        $response->assertSee('123-4567');
        $response->assertSee('三重県伊勢市123番地');
        $response->assertSee('石川アパート101号室');
    }
}
