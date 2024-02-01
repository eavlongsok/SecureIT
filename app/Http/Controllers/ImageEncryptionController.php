<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageEncryptionController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Validate the request (add any additional validation if needed)
        $request->validate([
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust accepted image types and size
        ]);

        // Store the uploaded image in storage/app/public
        $imagePath = $request->file('image')->store('public');

        // Check if the request is for encryption or decryption
        if ($request->has('encrypt')) {
            // Additional logic for image encryption if needed

            // Redirect to the result page for encryption
            return redirect()->route('image.result', ['action' => 'encrypt']);
        } elseif ($request->has('decrypt')) {
            // Additional logic for image decryption if needed

            // Redirect to the result page for decryption
            return redirect()->route('image.result', ['action' => 'decrypt']);
        } else {
            // Handle the case when neither 'encrypt' nor 'decrypt' is present in the request
            return redirect()->back()->with('error', 'Invalid action');
        }
    }
}
