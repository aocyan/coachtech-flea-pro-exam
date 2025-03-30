<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_authenticated_users_can_post_comments()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(3);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'user_comment_id' => $user->id,
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'comment' => 'テストコメント（ログイン）',
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 0,
        ]);

        $this->assertDatabaseHas('comments', [
            'user_comment_id' => $user->id,
            'product_comment_id' => $product->id,
            'comment' => 'テストコメント（ログイン）',
        ]);

        Auth()->logout();

        $product = Product::find(3);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response->assertSee('コメントを送信する');
        $response->assertSee('form__button-submit');
        $response->assertSee('no-form__button');
    }

    /** @test */
    public function comment_field_is_required()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(3);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'user_comment_id' => $user->id,
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'comment' => '',
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 0,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['comment']);

        $errors = session('errors')->get('comment');
        $this->assertEquals('コメントを入力してください', $errors[0]);
    }

    /** @test */
    public function comment_field_must_not_exceed_255_characters()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');
        $this->seed('ProductsTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $product = Product::find(3);

        $item_id = $product->id;
        $response = $this->get("/item/{$item_id}");

        $response = $this->post('/comments', [
            'image' => $user->profile->image,
            'name' => $user->name,
            'user_comment_id' => $user->id,
            'product_comment_id' => $product->id,
            'user_comment_id' => $user->id,
            'comment' => str_repeat('a', 256),
            'user_id' => $user->id,
            'product_id' => $product->id,
            'like' => 0,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['comment']);

        $errors = session('errors')->get('comment');
        $this->assertEquals('コメントは255文字以内で入力してください', $errors[0]);
    }
}