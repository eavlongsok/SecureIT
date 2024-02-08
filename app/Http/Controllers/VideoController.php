<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function showEncryptForm()
    {
        return view('video.encrypt');
    }

    public function showDecryptForm()
    {
        return view('video.decrypt');
    }

    public function encrypt(Request $request)
    {
        $validation = $request->validate([
            "video" => "required|mimes:mp4,webm|max:10000" 
        ]);

        $file = $request->file("video");
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $filename = 'encrypted_' . time() . '.' . $extension;
            $file->storeAs("public/videos", $filename);

            return redirect()->route('video.result')->with('filename', $filename)->with('status', 'Video encrypted successfully!');
        }

        return back()->withErrors(['video' => 'Please upload a valid video file.']);
    }

    public function decrypt(Request $request)
    {
        $validation = $request->validate([
            "video" => "required|mimes:mp4,webm|max:10000" 
        ]);

        $file = $request->file("video");
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $filename = 'decrypted_' . time() . '.' . $extension;
            $file->storeAs("public/videos", $filename);
            

            return redirect()->route('video.result')->with('filename', $filename)->with('status', 'Video decrypted successfully!');
        }

        return back()->withErrors(['video' => 'Please upload a valid video file.']);
    }

    public function showResult()
    {
        return view('video.result');
    }

    public function showVideo()
    {
        return view('video.video');
    }

}
