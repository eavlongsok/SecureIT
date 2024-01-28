<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    //
    public function encrypt(Request $request)
    {
        // save file from request as its own type
        $file = $request->file("video");
        // get file extension
        $extension = $file->getClientOriginalExtension();
        // store file
        $file->storeAs("public", "video." . $extension);
        return redirect("/video/encrypt/result");
    }
}
