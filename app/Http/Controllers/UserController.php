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
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'telephone' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string',
            'avatar' => 'nullable|string',
            'role' => 'required|string',
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'string',
            'prenom' => 'string',
            'telephone' => 'string',
            'username' => 'string|unique:users,username,' . $user->id,
            'email' => 'email|unique:users,email,' . $user->id, 
            'password' => 'string',
            'avatar' => 'nullable|string',
            'role' => 'string',
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