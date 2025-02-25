# laravel-passport-rest-API-unit-testing
User login and registraion, Blog CRUD with laravel Passport Rest API also with PHP unit-testing for the functionalities.

<pre>
Installation : 
    composer require laravel/passport
    php artisan migrate
    php artisan passport:install

    //User Model

    use Laravel\Passport\HasApiTokens;
    HasApiTokens
    
    config/auth.php

            'guards' => [
                'web' => [
                    'driver' => 'session',
                    'provider' => 'users',

        ],

                'api' => [
                    'driver' => 'passport', // set this to passport
                    'provider' => 'users',
                    'hash' => false,
                ],
            ],


    php artisan serve

API end points :

    API Routes :

        Register

            Request : 

                    POST => http://127.0.0.1:8000/api/register
                    Form Body => email, password, name
                    File => app\Http\Controllers\API\AuthController.php
                    method => register

            Response : {
                            "user": {
                                "name": "name",
                                "email": "name@example.com",
                                "updated_at": "2024-01-17T11:01:40.000000Z",
                                "created_at": "2024-01-17T11:01:40.000000Z",
                                "id": 1
                            },
                            "access_token": "toekn here"
                        }

        Login

            Request:
                    POST => http://127.0.0.1:8000/api/login
                    Form Body => email, password
                    File => app\Http\Controllers\API\AuthController.php
                    method => login
            Response:   {
                          "access_token": " access_token"
                        }

    Blog :

        Create 

            Request : 
                    Post =>  http://127.0.0.1:8000/api/blog
                    Form Body => blog_title , blog_content
                    Auth => Bearer Token : access_token_generated_from_login

            Response :
                        {
                            "blog": {
                                "blog_title": "Hello World",
                                "blog_content": "Welcome",
                                "user_id": 1,
                                "updated_at": "2024-01-17T11:06:55.000000Z",
                                "created_at": "2024-01-17T11:06:55.000000Z",
                                "id": 1
                            },
                            "message": "Blog created successfully"
                        }

        View Blog List

            Request : 
                    Get =>  http://127.0.0.1:8000/api/blog
                    Auth => Bearer Token : access_token_generated_from_login
            Response :
                        {
                            "blogs": [
                                {
                                "id": 1,
                                "user_id": 1,
                                "blog_title": "Hello World",
                                "blog_content": "Welcome",
                                "created_at": "2024-01-17T11:06:55.000000Z",
                                "updated_at": "2024-01-17T11:06:55.000000Z"
                                }
                            ]
                       }

        Update 

            Request : 
                    PUT =>  http://127.0.0.1:8000/api/blog/1
                    Form Body => blog_title , blog_content
                    Auth => Bearer Token : access_token_generated_from_login

            Response :
                        {
                            "blog": {
                                "id": 1,
                                "user_id": 1,
                                "blog_title": "Hello World",
                                "blog_content": "Life is beautiful",
                                "created_at": "2024-01-17T11:06:55.000000Z",
                                "updated_at": "2024-01-17T11:17:44.000000Z"
                            },
                            "message": "Blog updated successfully"
                        }

        
        Delete
            Request : 
                    DELETE =>  http://127.0.0.1:8000/api/blog/1
                    Auth => Bearer Token : access_token_generated_from_login
            Response :
                        {
                          "message": "Blog deleted successfully"
                        }
            
<br>

<pre>
// Check for required headers
    if ($request->header('Accept') !== 'application/json' || $request->header('Content-Type') !== 'application/json') {
        return response()->json([
            'error' => 'Malformed Headers',
            'message' => 'Please provide proper headers: Accept: application/json and Content-Type: application/json',
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'debug_info'=> $request->headers->all()
        ], 400); // 400 Bad Request
    }
</pre>
