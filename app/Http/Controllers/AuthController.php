<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mdp_tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            // Stocker le token dans la table mdp_tokens
            Mdp_tokens::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);

            return response()->json(['user' => $user, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    /**
     * Logout user and revoke token
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        // Supprimer le token de la table mdp_tokens
        Mdp_tokens::where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
