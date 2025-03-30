<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function purchase_is_completed_successfully()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/purchase/{$item_id}");

        $productId = $product->id;

        $response = $this->post("/purchase/{$productId}", [
            'pay' => 'コンビニ払い',
            'postal' => $user->profile->postal,
            'address' => $user->profile->address,
            'building' => $user->profile->building,
            'price' => $product->price,
        ]);

        $product = Product::find(2);

        $this->assertNotNull($product->sold_at);
    }

    /** @test */
    public function purchased_product_is_marked_as_sold_on_product_list()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/purchase/{$item_id}");

        $productId = $product->id;

        $response = $this->post("/purchase/{$productId}", [
            'pay' => 'コンビニ払い',
            'postal' => $user->profile->postal,
            'address' => $user->profile->address,
            'building' => $user->profile->building,
            'price' => $product->price,
        ]);

        $product = Product::find(2);

        $response = $this->get("/");

        $response->assertSee('sold');
    }

    /** @test */
    public function purchased_product_is_displayed_in_user_profile()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $product2 = Product::find(3);
        $product2->sold_at = now();
        $product2->save();

        $product3 = Product::find(4);

        $item_id = $product->id;
        $response = $this->get("/purchase/{$item_id}");

        $productId = $product->id;

        $response = $this->post("/purchase/{$productId}", [
            'pay' => 'コンビニ払い',
            'postal' => $user->profile->postal,
            'address' => $user->profile->address,
            'building' => $user->profile->building,
            'price' => $product->price,
        ]);

        $product = Product::find(2);
        $product2 = Product::find(3);
        $product3 = Product::find(4);

        $response = $this->get("/mypage?tab=buy");
        $response->assertStatus(200);

        $response->assertSee($product->name);
        $response->assertDontSee($product2->name);
        $response->assertDontSee($product3->name);
    }
}
