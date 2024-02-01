<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function encrypt(Request $request)
    {
        $validation = $request->validate([
            "video" => "required|mimes:mp4,webm|extensions:mp4,webm|max:10000"
        ]);

        // save file from request as its own type
        $file = $request->file("video");
        // get file extension
        $extension = $file->getClientOriginalExtension();
        // store file
        $file->storeAs("public", "video." . $extension);
        return redirect("/video/encrypt/result");
    }

    public function decrypt(Request $request)
    {
        // save file from request as its own type
        $file = $request->file("video");
        // get file extension
        $extension = $file->getClientOriginalExtension();
        // store file
        $file->storeAs("public", "video." . $extension);
        return redirect("/video/decrypt/result");
    }
}
