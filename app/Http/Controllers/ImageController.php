<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function showImagePage()
    {
        return view('image.image'); // Adjust the path to match your actual folder structure
    }
    public function encrypt(Request $request)
    {
        // Save the image from the request as its own type
        $file = $request->file("image");
        // Get the file extension
        $extension = $file->getClientOriginalExtension();
        // Store the image
        $file->storeAs("public", "image." . $extension);
        // return redirect("/image/encrypt/result");
        return redirect()->route('image.result'); // Update with your actual route

    }

public function decrypt(Request $request)
    {
        // Save the image from the request as its own type
        $file = $request->file("image");
        // Get the file extension
        $extension = $file->getClientOriginalExtension();
        // Store the image
        $file->storeAs("public", "image." . $extension);
        // return redirect("/image/decrypt/result");
        return redirect()->route('image.result'); // Update with your actual route

    }
}

