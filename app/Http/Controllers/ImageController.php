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
        return view('image.image');
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
            $request->validate([
                'key' => 'required|string|min:16|max:16',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePath = $request->file('image')->store('public');
            $key = $request->input('key');

            // Set session values
            session(['key' => $key, 'image_path' => $imagePath]);

            if ($request->has('encrypt')) {
                $this->encryptImage($imagePath, $key);
                return redirect()->route('image.result', ['action' => 'encrypt']);
            } elseif ($request->has('decrypt')) {
                $this->decryptImage($imagePath, $key);
                return redirect()->route('image.result', ['action' => 'decrypt']);
            } else {
                return redirect()->back()->with('error', 'Invalid action');
            }
        }


    public function encrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect("/image/encrypt")->withErrors($validate);
        }

        $file = $request->file('image');
        $key = $request->input('key');
        $extension = $file->getClientOriginalExtension();
        $file->storeAs('public', 'image_to_encrypt.' . $extension);

        $this->encryptImage('public/image_to_encrypt.' . $extension, $key);

        return redirect()->route('image.result', ['action' => 'encrypt']);
    }

    public function decrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'key' => 'required|string|min:16|max:16',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validate->fails()) {
            return redirect("/image/decrypt")->withErrors($validate);
        }

        $file = $request->file('image');
        $key = $request->input('key');
        $extension = $file->getClientOriginalExtension();
        $file->storeAs('public', 'image_to_decrypt.' . $extension);

        $this->decryptImage('public/image_to_decrypt.' . $extension, $key);

        return redirect()->route('image.result', ['action' => 'decrypt']);
    }

    public function showResult(Request $request)
{
    $type = $request->input('action');

    if ($type && session()->has('key') && session()->has('image_path')) {
        return view('image.result', [
            'type' => $type,
            'key' => session('key'),
            'image_path' => session('image_path'),
        ]);
    }

    // If conditions are not met or session data is missing, redirect to a different route
    return redirect()->route('image.show');
    
}


}