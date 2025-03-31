<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fetch_all_products()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $response = $this->get('/');

        $products = Product::all();

        foreach ($products as $product) 
        {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function it_displays_sold_after_product_is_purchased()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $product = Product::find(1);
        $this->assertNotNull($product);

        $product->sold_at = now();
        $product->save();

        $response = $this->get('/');

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
        $productByOtherUser = Product::find(2);

        $response = $this->get('/');

        $response->assertDontSee($productByUser->name);

        $response->assertSee($productByOtherUser->name);
    }
}
