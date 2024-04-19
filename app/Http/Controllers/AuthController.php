<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use App\Models\Encadrant;
use App\Models\Stagiaire;
use App\Models\Administrateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    // login a user methods
    public function login(LoginRequest $request) {

        $data = $request->validated();

        $user = Person::where('email', $data['email'])->first();

            if (!$user ) {
            return response()->json([
                'message' => 'Email is incorrect!'
            ], 401);
        }
//check if the user is alraedy logged
        $logged = DB::table('personal_access_tokens')
            ->where('tokenable_id', '=', $user->id)
            ->where(strtolower("tokenable_type"), '=', strtolower('App\Models\\' . $user->role))
            ->get()->first();
            if ($logged){
                DB::table('personal_access_tokens')->where('id', $logged->id)->delete();
                $token = $user->createToken('auth_token')->plainTextToken;
                $cookie = cookie('token', $token, 60 * 24); // 1 day
                return response()->json([
                'message' => 'alraedy logged',
                ])->withCookie($cookie);
            }
//check if the password is correct        
        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'password is incorrect!'
            ], 401);
        }
//create personal access token
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('token', $token, 60 * 24); // 1 day
        return response()->json([
            'user' => new UserResource($user),
           
        ])->withCookie($cookie);
    }
  
//register simple user
public function register(RegisterRequest $request) {
        $data = $request->validated();

        $user = User::create([
            'fullName' => $data['fullName'],
            'email' => $data['email'],
            'city' => $data['city'],
            'role' => $data['role'],
            'niveau_id' => $data['niveau_id'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24); // 1 day

        return response()->json([
            'message' => 'Registred successfully',
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
