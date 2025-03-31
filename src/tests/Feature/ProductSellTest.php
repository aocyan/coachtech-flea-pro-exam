<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductSellTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_product_information()
    {
        $this->seed('UsersTableSeeder');
        $this->seed('ProfilesTableSeeder');

        $user = User::with('profile')->find(1);
        $this->actingAs($user);

        $response = $this->get("/sell");
        $response->assertStatus(200);

        $imagePath = storage_path('app/public/products/Armani+Mens+Clock.jpg');


        $tempPath = sys_get_temp_dir() . '/' . basename($imagePath);
        copy($imagePath, $tempPath);

        $image = new UploadedFile($tempPath, 'Armani+Mens+Clock.jpg', 'image/jpeg', null, true);

        $response = $this->post('/sell/store', [
            'image' => $image,
            'category' => ['ファッション','メンズ', 'アクセサリー'],
            'condition' => '良好',
            'name' => '腕時計',
            'brand' => 'Armani',
            'color' => 'シルバー',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'product_user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Armani',
            'price' => '15000',
            'color' => 'シルバー',
            'image' => 'products/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
        ]);

        $product = Product::first();

        $categories = $product->categories->pluck('name');

        foreach ($categories as $category) 
        {
            $this->assertDatabaseHas('categories', [
                'name' => $category
            ]);
        }
    }
}
