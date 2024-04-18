<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'nullable|string',
            'phone' => 'nullable|string',
            'city' => 'nullable|string',
            'niveau_id' => 'nullable|string',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string',
            'avatar' => 'nullable|string',

        ]);

        
        $request->merge(['role' => 'simpleuser']);

        $user = User::create($request->all());
        return response()->json($user, 201);
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
