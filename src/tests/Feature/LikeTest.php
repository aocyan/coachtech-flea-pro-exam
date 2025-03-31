<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function product_details_are_displayed_correctly()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $likeCount = $product->likes->count();

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'comment' => 'テストコメント',
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 1,
        ]); 

        $product = Product::find(2);
        $updatedLikeCount = $product->likes->count();

        $this->assertEquals($likeCount + 1, $updatedLikeCount);
    }

    /** @test */
    public function test_like_button_changes_color_when_clicked()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'comment' => 'テストコメント',
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 1,
        ]); 

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $product = Product::find(2);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response->assertSee('checked');
    }

    /** @test */
    public function test_like_button_can_be_removed_when_clicked()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(2);

        $like = Like::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $likeCount = $product->likes->count();

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");
        $response->assertStatus(200);

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'comment' => 'テストコメント',
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 0,
        ]); 

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $product = Product::find(2);

        $updatedLikeCount = $product->likes->count();

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");
        $response->assertStatus(200);

        $response->assertDontSee('checked');
        $this->assertEquals($likeCount - 1, $updatedLikeCount);
    }
}
