<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function showImagePage()
    {
        return view('image.image'); // Adjust the path to match your actual folder structure
    }

    public function showEncryptForm()
    {
        return view('image.encrypt');
    }

    public function showDecryptForm()
    {
        return view('image.decrypt');
    }

    public function uploadImage(Request $request)
    {
        // Validate the request (add any additional validation if needed)
        $request->validate([
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust accepted image types and size
        ]);

        // Store the uploaded image in storage/app/public
        $imagePath = $request->file('image')->store('public');

        // Get the key from the request
        $key = $request->input('key');

        // Encrypt or decrypt the image based on the action parameter
        if ($request->has('encrypt')) {
            $this->encryptImage($imagePath, $key);
            // Redirect to the result page for encryption
            return redirect()->route('image.result', ['action' => 'encrypt']);
        } elseif ($request->has('decrypt')) {
            $this->decryptImage($imagePath, $key);
            // Redirect to the result page for decryption
            return redirect()->route('image.result', ['action' => 'decrypt']);

        } else {
            // Handle the case when neither 'encrypt' nor 'decrypt' is present in the request
            return redirect()->back()->with('error', 'Invalid action');
        }
    }

    public function encrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'image.required' => 'Please upload an image file or capture one',
            'image.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg',
            'image.max' => 'The image must be less than 2048',
            'key.required' => 'Please enter a key',
            'key.size' => 'The key must be 16 characters long',
        ]);

        if ($validate->fails()) {
            return redirect("/image/encrypt")->withErrors($validate);
        }

        $file = $request->file('image');
        $key = $request->input('key');
        $extension = $file->getClientOriginalExtension();
        $file->storeAs('public', 'image_to_encrypt.' . $extension);

        $this->encryptImage('public/image_to_encrypt.' . $extension, $key);

        return Redirect::route('image.result')->with([
            'type' => 'encryption',
            'key' => $key,
            'image_path' => asset('storage/encrypted/' . basename($imagePath)),
        ]);
    }

    public function decrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'image.required' => 'Please upload an image file or capture one',
            'image.mimes' => 'The image must be of type jpeg, png, jpg, gif, or svg',
            'image.max' => 'The image must be less than 2048',
            'key.required' => 'Please enter a key',
            'key.size' => 'The key must be 16 characters long',
        ]);

        if ($validate->fails()) {
            return redirect("/image/decrypt")->withErrors($validate);
        }

        $file = $request->file('image');
        $key = $request->input('key');
        $extension = $file->getClientOriginalExtension();
        $file->storeAs('public', 'image_to_decrypt.' . $extension);

        $this->decryptImage('public/image_to_decrypt.' . $extension, $key);

        return Redirect::route('image.result')->with([
            'type' => 'decryption',
            'key' => $key,
            'image_path' => asset('storage/decrypted/' . basename($imagePath)),
        ]);
    }

    public function showResult()
    {
        if (
            session()->has('type') &&
            session()->has('key') &&
            session()->has('image_path')
        ) {
            return view('image.result', [
                'type' => session('type'),
                'key' => session('key'),
                'image_path' => session('image_path'),
            ]);
        }

        return Redirect::route('image.result');
    }

   
}
