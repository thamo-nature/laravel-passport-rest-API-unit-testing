<?php

namespace Tests\Feature;

use Faker\Factory;
use Tests\TestCase;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class BlogTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function authenticate_and_get_access_token_to_pass_every_following_api_call()
    {

        $email = '1test@example.com';
        $password = 'password';
        
        if (!auth()->attempt(['email'=>$email, 'password'=>$password])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $access_token = array('access_token' => auth()->user()->createToken('authToken')->accessToken,
                                       'user_id'  => auth()->user()->id,   
                                    );
    }


    public function test_get_all_blog()
    {
        $token = $this->authenticate_and_get_access_token_to_pass_every_following_api_call();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token['access_token'],
        ])->json('GET','api/blog');

        $response->assertStatus(200);
    }


    public function test_create_blog()
    {


            // $user = User::factory()->create([
            //         'name' => 'Test User',
            //         'email' => time().'test@example.com',
            //         'password' => 'password',
            //         'access_token' => createToken('authToken')->accessToken,
            //     ]); 

           $token = $this->authenticate_and_get_access_token_to_pass_every_following_api_call();

            $response = $this->withHeaders([
                'Authorization' => 'Bearer '. $token['access_token'],
            ])->json('POST','api/blog',[
                'user_id' => $token['user_id'],
                'blog_title' => 'testing',
                'blog_content' => 'test-content'
            ]);

            $response->assertStatus(200);

    }


    public function test_update_blog()
    {
        $token = $this->authenticate_and_get_access_token_to_pass_every_following_api_call();
        
        $blog_i =  Blog::latest()->where('user_id', $token['user_id'])->first();

        $blog_id = $blog_i['id'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token['access_token'],
        ])->json('PUT','api/blog/'.$blog_id,[
            'user_id' => $token['user_id'],
            'blog_title' => 'testing update',
            'blog_content' => 'test-content updated content'
        ]);

        $response->assertStatus(200);
    }
    

    public function test_find_blog()
    {
        $token = $this->authenticate_and_get_access_token_to_pass_every_following_api_call();
        $blog_i =  Blog::latest()->where('user_id', $token['user_id'])->first();

        $blog_id = $blog_i['id'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token['access_token'],
        ])->json('GET','api/blog/'.$blog_id);

        $response->assertStatus(200);
    }

    public function test_delete_blog()
    {
        $token = $this->authenticate_and_get_access_token_to_pass_every_following_api_call();
        $blog_i =  Blog::latest()->where('user_id', $token['user_id'])->first();

        $blog_id = $blog_i['id'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token['access_token'],
        ])->json('DELETE','api/blog/'.$blog_id);



        $response->assertStatus(200);
    }
}
