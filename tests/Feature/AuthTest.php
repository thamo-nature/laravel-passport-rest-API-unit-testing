<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_register_user()
    {
        $get_server_response = $this->json(
            'post',
            'http://localhost:8000/api/register',
            [
                'name'  =>  $name = 'Test',
                'email'  =>  $email = rand(1,2) . 'test@example.com',
                'password'  =>  $password = 'password',
            ],

            //checking with malformed headers
            [
                // 'content-type' => 'image/*',
                // 'accept' => 'image/*'
            ],

        );


        $get_server_response->assertStatus(200);

        $this->assertArrayHasKey('access_token', $get_server_response->json());
    }


    public function test_login_user()
    {

        $email = rand(1,2) . 'test@example.com';
        $password = 'password';
        
        $response = $this->json('POST','http://localhost:8000/api/login',[
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(200);

        $this->assertArrayHasKey('access_token',$response->json());

        // Delete users
        User::where('email',$email)->delete();
    }
    
}
