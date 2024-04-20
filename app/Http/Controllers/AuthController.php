<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Admin;
use App\Traits\Refactor;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;


class AuthController extends Controller
{
    use Refactor;
    use Store;
    use Update;
    // login a user methods
    public function login(LoginRequest $request) {

        $data = $request->validated();

        $profile= Profile::where('email', $data['email'])->first();
            if (!$profile) {
            return response()->json([
                'message' => "The email address you've entered does not exist. Please verify your email and try again"
            ], 401);
        }
//check if the password is correct        
        if (!Hash::check($data['password'], $profile->password)) {
            return response()->json([
                'message' => "The password you've entered is incorrect. Please check your password and try again."
            ], 401);
        }
//check if the user is alraedy logged
        $logged = DB::table('personal_access_tokens')
            ->where('tokenable_id', '=', $profile->id)
            ->get()->first();
            if ($logged){
                DB::table('personal_access_tokens')->where('id', $logged->id)->delete();
                $token = $profile->createToken('auth_token')->plainTextToken;
                $cookie = cookie('token', $token, 60 * 24); // 1 day
                return response()->json([
                'message' => 'alraedy logged',
                ])->withCookie($cookie);
            }
//create personal access token
        $token = $profile->createToken('auth_token')->plainTextToken;
        $cookie = cookie('token', $token, 60 * 24); // 1 day
        return response()->json($this->refactorProfile($profile))->withCookie($cookie);
    }

    //store all users 
    public function store(Request $request) {
        $profile=$this->storeProfile($request);
        $token = $profile->createToken('auth_token')->plainTextToken;
        $cookie = cookie('token', $token, 60 * 24); // 1 day
        return response()->json($this->refactorProfile($profile))->withCookie($cookie);
    }

    public function update(Request $request){
        $profile = Profile::find($request->id);
        if (!$profile) {
            return response()->json(['message' => 'profile non trouvé'], 404);
        }
        $newProfile =$this->updateProfile($request);
        return response()->json($this->refactorProfile($newProfile));
    }
  // logout 
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        $cookie = cookie()->forget('token');
        return response()->json([
            'message' => 'Logged out successfully!'
        ])->withCookie($cookie);
    }

    // get the authenticated user method
    public function user(Request $request) {
        return  response()->json($this->refactorProfile($request->user()));
    }

}
