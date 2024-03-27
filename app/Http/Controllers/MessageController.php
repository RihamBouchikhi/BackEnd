<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $message = Message::all();
        return response()->json($message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = new Message([
            'emetteur_id' => $request->input('emetteur_id'),
            'recepteur_id' => $request->input('recepteur_id'),
            'contenu' => $request->input('contenu'),
            'est_lu' => $request->input('est_lu'),
        ]);
        $message->save();
        return response()->json('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Message::find($id) ;
        return response()->json($message);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message = Message::find($id);
        $message->update($request->all());
        return response()->json('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = Message::find($id);
        $message->delete();
        return response()->json('');
    }
}
