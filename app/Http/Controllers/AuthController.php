<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\CreateUserRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid login credentials'], 401);
        }

        $token = auth('api')->setTTL(20160)->login($user);

        return $this->createNewToken($token);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
            'user' => auth('api')->user(),
            'status' => 'success',
            "message" => "Successful login",
        ], 200);
    }

    public function createAdmin(CreateUserRequest $request)
    {
        $merchantkey = date("Y-m-d h:i:sa") . rand(111111, 999999);
        $authid = md5($merchantkey);

        $insert_fields = array('email' => $request->email, 'authid' => $authid, 'firstname' => $request->firstname, 'lastname' => $request->lastname, 'password' => Hash::make("123456"));
        $admin = User::create($insert_fields);

        return response()->json(['status' => 'success', 'message' => 'User created successfully', 'admin' => $admin], 200);
    }
}
