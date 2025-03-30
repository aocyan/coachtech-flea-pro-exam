<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function subtotal_is_updated_immediately_on_page()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/purchase/{$item_id}");
        $response = $this->get("/purchase/{$item_id}?pay=コンビニ払い");
        $response->assertSee('コンビニ払い');
    }
}
