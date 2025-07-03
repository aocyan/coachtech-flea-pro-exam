<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name' => '山本　太郎',
            'email' => 'test1@example.com',
            'password' => bcrypt('1234abcd'), 
        ]);

        User::create([
            'id' => 2,
            'name' => '鈴木　次郎',
            'email' => 'test2@example.com',
            'password' => bcrypt('1234abcd'),
        ]);

        User::create([
            'id' => 3,
            'name' => '佐藤　春子',
            'email' => 'test3@example.com',
            'password' => bcrypt('1234abcd'),
        ]);     
    }
}
