<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{

    public function upload(Request $request)
    {
        $data = $request->input('data');

        // Create a new image record in the database
        $image = new Image();
        $image->data = $data;
        $image->save();

        return response()->json(['message' => 'Image uploaded successfully'], 200);
    }

    public function index()
    {
        $images = Image::all(['id', 'data', 'created_at']);

        return response()->json($images);
    }

}
