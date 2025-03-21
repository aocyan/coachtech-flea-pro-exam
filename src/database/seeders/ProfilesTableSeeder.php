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
            'profile_user_id' => 1,
        ]);

        Profile::create([
            'image' => 'grapes.png',
            'postal' => '123-5678',
            'address' => '三重県熊野市123番地',
            'building' => '富山アパート101号室',
            'profile_user_id' => 2,
        ]);

        Profile::create([
            'image' => 'kiwi.png',
            'postal' => '123-6789',
            'address' => '三重県松阪市123番地',
            'building' => '岐阜アパート101号室',
            'profile_user_id' => 3,
        ]);

        Profile::create([
            'image' => 'melon.png',
            'postal' => '123-1234',
            'address' => '三重県熊野市123番地',
            'building' => '新潟アパート101号室',
            'profile_user_id' => 4,
        ]);

        Profile::create([
            'image' => 'muscat.png',
            'postal' => '123-2345',
            'address' => '三重県鈴鹿市123番地',
            'building' => '愛知アパート101号室',
            'profile_user_id' => 5,
        ]);

        Profile::create([
            'image' => 'orange.png',
            'postal' => '123-3456',
            'address' => '三重県伊賀市123番地',
            'building' => '滋賀アパート101号室',
            'profile_user_id' => 6,
        ]);

        Profile::create([
            'image' => 'peach.png',
            'postal' => '123-9012',
            'address' => '三重県四日市市123番地',
            'building' => '京都アパート101号室',
            'profile_user_id' => 7,
        ]);

        Profile::create([
            'image' => 'pineapple.png',
            'postal' => '123-8765',
            'address' => '三重県いなべ市123番地',
            'building' => '長野アパート101号室',
            'profile_user_id' => 8,
        ]);

        Profile::create([
            'image' => 'strawberry.png',
            'postal' => '123-7654',
            'address' => '三重県名張市123番地',
            'building' => '静岡アパート101号室',
            'profile_user_id' => 9,
        ]);

        Profile::create([
            'image' => 'watermelon.png',
            'postal' => '123-8653',
            'address' => '三重県尾鷲市123番地',
            'building' => '和歌山アパート101号室',
            'profile_user_id' => 10,
        ]);
    }
}
