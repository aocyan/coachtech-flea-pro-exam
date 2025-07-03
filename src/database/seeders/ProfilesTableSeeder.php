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
    }
}
