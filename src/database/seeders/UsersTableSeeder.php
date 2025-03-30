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

        User::create([
            'id' => 4,
            'name' => '森　夏子',
            'email' => 'test4@example.com',
            'password' => bcrypt('1234abcd'), 
        ]);

        User::create([
            'id' => 5,
            'name' => '石田　秋子',
            'email' => 'test5@example.com',
            'password' => bcrypt('1234abcd'),
        ]);

        User::create([
            'id' => 6,
            'name' => '加藤　冬子',
            'email' => 'test6@example.com',
            'password' => bcrypt('1234abcd'),
        ]);

        User::create([
            'id' => 7,
            'name' => '吉田　三郎',
            'email' => 'test7@example.com',
            'password' => bcrypt('1234abcd'), 
        ]);

        User::create([
            'id' => 8,
            'name' => '坂部　四郎',
            'email' => 'test8@example.com',
            'password' => bcrypt('1234abcd'),
        ]);

        User::create([
            'id' => 9,
            'name' => '舘　五郎',
            'email' => 'test9@example.com',
            'password' => bcrypt('1234abcd'),
        ]);

        User::create([
            'id' => 10,
            'name' => '伊藤　佳子',
            'email' => 'test10@example.com',
            'password' => bcrypt('1234abcd'),
        ]);
    }
}
