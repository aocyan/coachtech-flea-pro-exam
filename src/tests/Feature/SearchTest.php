<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_product_search()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $product = Product::find(1);

        $response = $this->get('/search?query=' . urlencode($product->name));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /** @test */
    public function test_search_results_are_retained_in_mylist()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::find(1);
        $this->actingAs($user);

        $product1 = Product::find(2);
        $product2 = Product::find(3);
        $product3 = Product::find(4);

        LIke::create([
            'user_id' => $user->id,
            'product_id' => $product1->id,
        ]);
        LIke::create([
            'user_id' => $user->id,
            'product_id' => $product2->id,
        ]);

        $response = $this->get('/?tab=mylist&query=' . urlencode($product1->name));

        $response->assertStatus(200);
        $response->assertSee($product1->name);
    }
}