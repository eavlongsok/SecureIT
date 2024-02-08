<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function showEncryptForm()
    {
        return view('image.encrypt_image');
    }

    public function showDecryptForm()
    {
        return view('image.decrypt_image');
    }

    public function encrypt(Request $request)
    {
        $file = $request->file("image");

        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $filename = 'encrypted_' . time() . '.' . $extension;
            $file->storeAs("public/images", $filename);

            return redirect()->route('image.result')->with('filename', $filename)->with('status', 'Image encrypted successfully!');
        }

        return back()->withErrors(['image' => 'Please upload a valid image.']);
    }

    public function decrypt(Request $request)
    {
        $file = $request->file("image");

        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $filename = 'decrypted_' . time() . '.' . $extension;
            $file->storeAs("public/images", $filename);
            

            return redirect()->route('image.result')->with('filename', $filename)->with('status', 'Image decrypted successfully!');
        }

        return back()->withErrors(['image' => 'Please upload a valid image.']);
    }

    public function showResult()
    {
        return view('image.result');
    }

    public function showImage()
    {
        return view('image.image');
    }
}
