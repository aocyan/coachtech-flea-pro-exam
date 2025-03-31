<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_field_is_required()
    {
        $this->seed('UsersTableSeeder');

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response = $this->post('/login/certification', [
            'email' => '',
            'password' => '1234abcd',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);

        $errors = session('errors')->get('email');
        $this->assertEquals('メールアドレスを入力してください', $errors[0]);
    }
    
    /** @test */
    public function password_field_is_required()
    {
        $this->seed('UsersTableSeeder');

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response = $this->post('/login/certification', [
            'email' => 'test1@example.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['password']);

        $errors = session('errors')->get('password');
        $this->assertEquals('パスワードを入力してください', $errors[0]);
    }

    /** @test */
    public function password_login_information_is_not_registered()
    {
        $this->seed('UsersTableSeeder');

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response = $this->post('/login/certification', [
            'email' => 'test1@example.com',
            'password' => '1234mistake',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);

        $errors = session('errors')->get('email');
        $this->assertEquals('ログイン情報が登録されていません', $errors[0]);
    }

    /** @test */
    public function email_login_information_is_not_registered()
    {
        $this->seed('UsersTableSeeder');

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response = $this->post('/login/certification', [
            'email' => 'mistake@example.com',
            'password' => '1234abcd',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);

        $errors = session('errors')->get('email');
        $this->assertEquals('ログイン情報が登録されていません', $errors[0]);
    }

    /** @test */
    public function login_success_redirects_to_index()
    {
        $this->seed('UsersTableSeeder');     

        $response = $this->get('/login');

        $response->assertStatus(200);

        $response = $this->post('/login/certification', [
            'email' => 'test1@example.com',
            'password' => '1234abcd',
        ]);

        $response->assertRedirect('/');
        $response->assertStatus(302);
    }
}
