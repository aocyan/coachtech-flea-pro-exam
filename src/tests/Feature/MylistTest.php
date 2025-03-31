<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_only_favorited_products_in_mylist()
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

        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);

        $response->assertSee($product1->name);
        $response->assertSee($product2->name);

        $response->assertDontSee($product3->name);
    }

    /** @test */
    public function it_displays_sold_after_product_is_purchased()
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

        $product1->sold_at = now();
        $product1->save();

        $response = $this->get('/?tab=mylist');

        $response->assertSee('sold');
    }

    /** @test */
    public function it_hides_products_posted_by_the_user()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::find(1);
        $this->actingAs($user);

        $productByUser = Product::find(1);
        $productByLikeUser = Product::find(2);
        $productByOtherUser = Product::find(3);

        LIke::create([
            'user_id' => $user->id,
            'product_id' => $productByLikeUser->id,
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee($productByUser->name);

        $response->assertSee($productByLikeUser->name);

        $response->assertDontSee($productByOtherUser->name);
    }

    /** @test */
    public function guest_sees_nothing()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');
        
        $products = Product::all();

        $response = $this->get('/?tab=mylist');

        foreach ($products as $product) 
        {
            $response->assertDontSee($product->name);
        }
    }
}
