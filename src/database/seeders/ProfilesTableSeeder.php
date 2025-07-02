<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            'image' => 'banana.png',
            'postal' => '123-4567',
            'address' => '三重県伊勢市123番地',
            'building' => '石川アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(1)->id,
        ]);

        Profile::create([
            'image' => 'grapes.png',
            'postal' => '123-5678',
            'address' => '三重県熊野市123番地',
            'building' => '富山アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(2)->id,
        ]);

        Profile::create([
            'image' => 'kiwi.png',
            'postal' => '123-6789',
            'address' => '三重県松阪市123番地',
            'building' => '岐阜アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(3)->id,
        ]);

        Profile::create([
            'image' => 'melon.png',
            'postal' => '123-1234',
            'address' => '三重県熊野市123番地',
            'building' => '新潟アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(4)->id,
        ]);

        Profile::create([
            'image' => 'muscat.png',
            'postal' => '123-2345',
            'address' => '三重県鈴鹿市123番地',
            'building' => '愛知アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(5)->id,
        ]);

        Profile::create([
            'image' => 'orange.png',
            'postal' => '123-3456',
            'address' => '三重県伊賀市123番地',
            'building' => '滋賀アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(6)->id,
        ]);

        Profile::create([
            'image' => 'peach.png',
            'postal' => '123-9012',
            'address' => '三重県四日市市123番地',
            'building' => '京都アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(7)->id,
        ]);

        Profile::create([
            'image' => 'pineapple.png',
            'postal' => '123-8765',
            'address' => '三重県いなべ市123番地',
            'building' => '長野アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(8)->id,
        ]);

        Profile::create([
            'image' => 'strawberry.png',
            'postal' => '123-7654',
            'address' => '三重県名張市123番地',
            'building' => '静岡アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(9)->id,
        ]);

        Profile::create([
            'image' => 'watermelon.png',
            'postal' => '123-8653',
            'address' => '三重県尾鷲市123番地',
            'building' => '和歌山アパート101号室',
            'evaluation' => '0',
            'evaluation_count' => '0',
            'before_evaluation_count' => '0',
            'profile_user_id' => User::find(10)->id,
        ]);
    }
}
