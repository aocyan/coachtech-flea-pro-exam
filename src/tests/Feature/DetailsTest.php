<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Category;
use App\Models\Like;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function product_details_are_displayed_correctly()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user1 = User::with('profile')->find(1);
        $user2 = User::with('profile')->find(2);

        $product = Product::find(3);

        $like1 = Like::create([
            'user_id' => $user1->id,
            'product_id' => $product->id,
        ]);
        $like2 = Like::create([
            'user_id' => $user2->id,
            'product_id' => $product->id,
        ]);
        $likeCount = Like::where('product_id', $product->id)->count();

        $commentUser = $user1;
        $comment = Comment::create([
            'product_comment_id' => $product->id,
            'user_comment_id' => $commentUser->id,
            'comment' => 'テストコメント',
        ]); 

        $commentCount = Comment::where('product_comment_id', $product->id)->count();

        $categories = $product->categories->pluck('name');

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");
        $response->assertStatus(200);

        $response->assertSee($product->name);
        $response->assertSee($product->brand);
        $response->assertSee(number_format($product->price));
        $response->assertSee($product->description);
        $response->assertSee($product->condition);
        foreach ($categories as $category) 
        {
            $response->assertSee($category);
        }
        $response->assertSee((string)$likeCount);
        $response->assertSee((string)$commentCount);
        $response->assertSee($commentUser->name);
        $response->assertSee($commentUser->image);
        $response->assertSee('iLoveIMG');   
    }

    /** @test */
    public function product_details_show_multiple_categories()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user1 = User::with('profile')->find(1);
        $product = Product::find(1);

        $categories = $product->categories->pluck('name');

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");
        $response->assertStatus(200);

        foreach ($categories as $category) 
        {
            $response->assertSee($category);
        }
    }
}
