<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullName' => 'string',
            'phone' => 'string',
            'city' => 'string',
            'niveau_id' => 'string',
            'email' => 'email|unique:users,email,' . $user->id, 
            'password' => 'string',
            'avatar' => 'nullable|string',
        ]);

        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
