<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profiles = Profile::all();
        return response()->json($profiles);
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:profiles,email',
            'password' => 'required|string',

        ]);

        $profile = Profile::create([
            'fullName' => $validatedData['fullName'],
            'phone' => $validatedData['phone'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), 
            
        ]);

        return response()->json(['profile' => $profile], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $Profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $Profile)
    {
        //
    }
}
