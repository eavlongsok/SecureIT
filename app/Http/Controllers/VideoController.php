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

<<<<<<< Updated upstream
        return back()->withErrors(['video' => 'Please upload a valid video file.']);
=======
        // save file from request as its own type
        $file = $request->file("video");
        $key = $request->input("key");
        // get file extension
        $extension = $file->getClientOriginalExtension();
        // store file
        $video_path = $file->storeAs("public", "video_to_encrypt." . $extension);
//        dd('python "' . base_path() . '\scripts\main.py" -t encrypt -f video -k "' . $key . '" -p "' . base_path() . '\storage\app\public\video_to_encrypt.' . $extension . '"');
        $output = shell_exec('python "' . base_path() . '\scripts\main.py" -t encrypt -f video -k "' . $key . '" -p "' . base_path() . '\storage\app\public\video_to_encrypt.' . $extension . '"');

        return Redirect::route('video.result')->with(["type" => "encryption", "key" => $key, "video_path" => $video_path]);
>>>>>>> Stashed changes
    }

    public function decrypt(Request $request)
    {
        $validation = $request->validate([
            "video" => "required|mimes:mp4,webm|max:10000" 
        ]);

        $file = $request->file("video");
<<<<<<< Updated upstream
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $filename = 'decrypted_' . time() . '.' . $extension;
            $file->storeAs("public/videos", $filename);
            

            return redirect()->route('video.result')->with('filename', $filename)->with('status', 'Video decrypted successfully!');
        }

        return back()->withErrors(['video' => 'Please upload a valid video file.']);
=======
        $key = $request->input("key");
        // get file extension
        $extension = $file->getClientOriginalExtension();
        // store file
        $video_path = $file->storeAs("public", "video_to_dncrypt." . $extension);

//        dd('python "' . base_path() . '\scripts\main.py" -t decrypt -f video -k "' . $key . '" -p "' . base_path() . '\storage\app\public\video_to_decrypt.' . $extension . '"');
        $output = shell_exec('python "' . base_path() . '\scripts\main.py" -t decrypt -f video -k "' . $key . '" -p "' . base_path() . '\storage\app\public\video_to_decrypt.' . $extension . '"');
        return Redirect::route('video.result')->with(["type" => "decryption", "key" => $key, "video_path" => $video_path]);
>>>>>>> Stashed changes
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
