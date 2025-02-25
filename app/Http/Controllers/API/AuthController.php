<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

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
        
        if ($request->accepts(['text/html', 'application/json'])) {
 
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:55',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response(['error' => $validator->errors()]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['user' => $user, 'access_token' => $accessToken]);
        } else {

            return response(['Headers' => 'Malformed Headers', 'Action' => 'Please try again']);
        }
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        if (!auth()->attempt($data)) {
            return response(['message' => 'Login credentials are invaild']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['access_token' => $accessToken]);

    }
}
