<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Traits\Delete;
use App\Traits\Get;
use App\Traits\Refactor;
use App\Traits\Store;
use App\Traits\Update;
use Illuminate\Http\Request;

class ProfileController
{
    use Refactor, Store, Delete, Update;
    
    //store all users 
    public function store(Request $request) {
        $profile=$this->storeProfile($request);
        return response()->json($this->refactorProfile($profile));
    }
    public function register(Request $request){
        $profile = $this->storeUser($request);
        $token = $profile->createToken('auth_token')->plainTextToken;
        $cookie = cookie('token', $token, 60 * 24); // 1 day
        return response()->json($this->refactorProfile($profile))->withCookie($cookie);
    }
//update profiles
    public function update(Request $request, string $id){
        $profile = Profile::find($id);
        if (!$profile) {
            return response()->json(['message' => 'profile non trouvé'], 404);
        }
        $newProfile =$this->updateProfile($request,$profile);
        return response()->json($this->refactorProfile($newProfile));
    }

    public function show(string $id){
      $profile = Profile::find($id);
        if (!$profile) { 
            return response()->json(['message' => 'profile non trouvé'], 404);
        }  
        return response()->json($this->refactorProfile($profile));
    }
//delete profiles
    public function destroy(string $id){
    $profile = Profile::find($id);
        if (!$profile) {
            return response()->json(['message' => 'profile non trouvé'], 404);
        }
    $isDeleted =$this->deleteProfile($profile);
    if ($isDeleted){       
        return response()->json(['message' => 'profile deleted succsfully'],200);
    }
}

}
