<?php

namespace Tests\Feature;

use App\Models\Delivery;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeliveryTest extends TestCase
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

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/purchase/address/{$item_id}");
        $response->assertStatus(200);

        $response->assertSee('123-4567');
        $response->assertSee('三重県伊勢市123番地');
        $response->assertSee('石川アパート101号室');

        $response = $this->patch("/address/update/{$item_id}", [
            'postal' => '765-4321',
            'address' => 'テスト住所',
            'building' => 'テストアパート',
        ]);

        $response = $this->get("/purchase/{$item_id}");
        $response->assertStatus(200);

        $response->assertSee('765-4321');
        $response->assertSee('テスト住所');
        $response->assertSee('テストアパート');
    }

    /** @test */
    public function shipping_address_is_saved_to_database()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/purchase/address/{$item_id}");
        $response->assertStatus(200);

        $response->assertSee('123-4567');
        $response->assertSee('三重県伊勢市123番地');
        $response->assertSee('石川アパート101号室');

        $response = $this->patch("/address/update/{$item_id}", [
            'postal' => '765-4321',
            'address' => 'テスト住所',
            'building' => 'テストアパート',
        ]);

        $response = $this->get("/purchase/{$item_id}");
        $response->assertStatus(200);

        $response->assertSee('765-4321');
        $response->assertSee('テスト住所');
        $response->assertSee('テストアパート');

        $productId = $product->id;

        $response = $this->post("/purchase/{$productId}", [
            'pay' => 'コンビニ払い',
            'postal' => $user->profile->postal,
            'address' => $user->profile->address,
            'building' => $user->profile->building,
            'price' => $product->price,
        ]);

        $response = $this->get("/thanks");

        $this->assertDatabaseHas('deliveries', [
            'product_delivery_id' => $product->id,
            'postal' => '765-4321',
            'address' => 'テスト住所',
            'building' => 'テストアパート',
        ]);
    }
}
