<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|string|unique:users,email',
        'password' => [
            'required',
            'confirmed',
            Password::min(8)->mixedCase()->numbers()->symbols()
        ],
        'role_id' => 'required|in:1,2',
    ]);

    
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'role_id' => $request->role_id
    ]);

    $token = $user->createToken('main')->plainTextToken;

    return response([
        'user' => $user,
        'token' => $token
    ]);
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->currentAccessToken()->delete();
        }

        return response([
            'success' => true
        ]);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }

}