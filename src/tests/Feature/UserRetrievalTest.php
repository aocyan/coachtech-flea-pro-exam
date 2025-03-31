<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRetrievalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_change_shipping_address()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product1 = Product::find(1);
        $product2 = Product::find(2);
        $product3 = Product::find(3);

        $this->assertDatabaseHas('products', [
            'id' => $product1->id,
            'product_user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '山本　太郎',
        ]);
        $this->assertDatabaseHas('profiles', [
            'profile_user_id' => $user->id,
            'image' => 'banana.png',
        ]);

        $product2->update([
            'user_id' => $user->id,
            'purchaser_user_id' => $user->id,
        ]);

        $response = $this->get("/mypage");
        $response->assertStatus(200);

        $response->assertSee('山本　太郎');
        $response->assertSee('banana');

        $response = $this->get("/mypage?tab=sell");
        $response->assertStatus(200);

        $response->assertSee($product1->name);
        $response->assertDontSee($product2->name);
        $response->assertDontSee($product3->name);

        $response = $this->get("/mypage?tab=buy");
        $response->assertStatus(200);

        $response->assertSee($product2->name);
        $response->assertDontSee($product1->name);
        $response->assertDontSee($product3->name);
    }
}
