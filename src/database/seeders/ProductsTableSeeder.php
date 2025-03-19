<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        $categories = [
            'ファッション',
            '家電', 
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本',
            'ゲーム',
            'スポーツ',
            'キッチン',
            'ハンドメイド',
            'アクセサリー',
            'おもちゃ',
            'ベビー・キッズ',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insertOrIgnore([
                'name' => $category,
            ]);
        }

        $watchId = DB::table('products')->insertGetId([
            'name' => '腕時計',
            'brand' => 'Armani',
            'price' => '15000',
            'color' => 'シルバー',
            'image' => 'products/Armani+Mens+Clock.jpg',
            'condition' => '良好',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'product_user_id' => 1, 
        ]);

        $categories = ['ファッション','メンズ', 'アクセサリー'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $watchId,
                'category_id' => $categoryId,
            ]);
        }

        $hddId = DB::table('products')->insertGetId([
            'name' => 'HDD',
            'brand' => 'Sony',
            'price' => '5000',
            'color' => 'ブラック',
            'image' => 'products/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高速で信頼性の高いハードディスク',
            'product_user_id' => 2,
        ]);

        $categories = ['家電'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $hddId,
                'category_id' => $categoryId,
            ]);
        }

        $onionId = DB::table('products')->insertGetId([
            'name' => '玉ねぎ3束',
            'brand' => 'メガドンキ',
            'price' => '300',
            'color' => 'ホワイト',
            'image' => 'products/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => '新鮮な玉ねぎ3束のセット',
            'product_user_id' => 3,
        ]);

        $categories = ['キッチン'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $onionId,
                'category_id' => $categoryId,
            ]);
        }

        $shoesId = DB::table('products')->insertGetId([
            'name' => '革靴',
            'brand' => 'Aoyama',
            'price' => '4000',
            'color' => 'ブラック',
            'image' => 'products/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
            'description' => 'クラシックなデザインの革靴',
            'product_user_id' => 4,
        ]);

        $categories = ['ファッション','メンズ'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $shoesId,
                'category_id' => $categoryId,
            ]);
        }

        $laptopId = DB::table('products')->insertGetId([
            'name' => 'ノートPC',
            'brand' => 'dell',
            'price' => '45000',
            'color' => 'グレー',
            'image' => 'products/Living+Room+Laptop.jpg',
            'condition' => '良好',
            'description' => '高性能なノートパソコン',
            'product_user_id' => 5,
        ]);

        $categories = ['家電','ゲーム'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $laptopId,
                'category_id' => $categoryId,
            ]);
        }

        $microphoneId = DB::table('products')->insertGetId([
            'name' => 'マイク',
            'brand' => 'Logitec',
            'price' => '8000',
            'color' => 'ブラック',
            'image' => 'products/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '高音質のレコーディング用マイク',
            'product_user_id' => 6,
        ]);

        $categories = ['家電','おもちゃ'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $microphoneId,
                'category_id' => $categoryId,
            ]);
        }

        $bagId = DB::table('products')->insertGetId([
            'name' => 'ショルダーバッグ',
            'brand' => 'Hermes',
            'price' => '3500',
            'color' => 'レッド',
            'image' => 'products/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
            'description' => 'おしゃれなショルダーバッグ',
            'product_user_id' => 7,
        ]);

        $categories = ['ファッション','レディース'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $bagId,
                'category_id' => $categoryId,
            ]);
        }

        $tumblerId = DB::table('products')->insertGetId([
            'name' => 'タンブラー',
            'brand' => 'Souvenir',
            'price' => '500',
            'color' => 'ブラック',
            'image' => 'products/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
            'description' => '使いやすいタンブラー',
            'product_user_id' => 8,
        ]);

        $categories = ['メンズ','スポーツ'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $tumblerId,
                'category_id' => $categoryId,
            ]);
        }

        $grinderId = DB::table('products')->insertGetId([
            'name' => 'コーヒーミル',
            'brand' => 'ニトリ',
            'price' => '4000',
            'color' => 'ブラック',
            'image' => 'products/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
            'description' => '手動のコーヒーミル',
            'product_user_id' => 9,
        ]);

        $categories = ['インテリア'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $grinderId,
                'category_id' => $categoryId,
            ]);
        }

        $makeupId = DB::table('products')->insertGetId([
            'name' => 'メイクセット',
            'brand' => 'HABA',
            'price' => '2500',
            'color' => 'ピンク',
            'image' => 'products/makeup.jpg',
            'condition' => '目立った傷や汚れなし',
            'description' => '便利なメイクアップセット',
            'product_user_id' => 10,
        ]);

        $categories = ['レディース','コスメ'];

        foreach($categories as $category) {
            $categoryId = DB::table('categories')->where('name', $category)->value('id');

            DB::table('product_category')->insert([
                'product_id' => $makeupId,
                'category_id' => $categoryId,
            ]);
        }
    }
}
