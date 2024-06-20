<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    //Method for user registration
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
            'role_id' => 'required|in:1,2,3',
        ]);

        //Create a new user with validated data
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $request->role_id
        ]);

                // Attach role to user
                $role = Role::find($request->role_id);
                $user->roles()->attach($role);

        $token = $user->createToken('main')->plainTextToken;

        //Return response with user data and token
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
    //Method for user login
    public function login(Request $request)
    {
        //Validate the user credentials 
        $credentials = $request->validate([
            'email' => 'required|email|string|exists:users,email',
            'password' => [
                'required',
            ],
            'remember' => 'boolean'
        ]);
        //Check if the remember option is set
        $remember = $credentials['remember'] ?? false;
        //Remove remember from credentials array
        unset($credentials['remember']);

        // Attempt to authenticate the user with the provided credentials
        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }

        // Retrieve the authenticated user
        $user = Auth::user();
        // Create an API token for the authenticated user
        $token = $user->createToken('main')->plainTextToken;

        // Return response with user data and token
        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    //Method for user logout
    public function logout()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve the authenticated user
            $user = Auth::user();
            $user->currentAccessToken()->delete();
        }

        return response([
            'success' => true
        ]);
    }

    // Method to get the authenticated user's details
    public function getUser(Request $request)
    {
    
        return new UserResource($request->user());
    }
}