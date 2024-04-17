<?php

namespace App\Http\Controllers;

use App\Models\Administrateur;
use App\Models\Encadrant;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{

      // login a user methods
    public function login(LoginRequest $request) {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first()
            ??Administrateur::where('email', $data['email'])->first()
            ?? Encadrant::where('email', $data['email'])->first()
            ?? Stagiaire::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect!'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24); // 1 day

        return response()->json([
            'user' => new UserResource($user),
        ])->withCookie($cookie);
    }
 public function register(RegisterRequest $request) {

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24); // 1 day

        return response()->json([
            'user' => new UserResource($user),
        ])->withCookie($cookie);
    }
        // logout a user method
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $cookie = cookie()->forget('token');

        return response()->json([
            'message' => 'Logged out successfully!'
        ])->withCookie($cookie);
    }

    // get the authenticated user method
    public function user(Request $request) {
        return new UserResource($request->user());
    }
}
