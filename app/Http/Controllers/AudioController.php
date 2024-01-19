<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function encrypt(Request $request)
    {

        $file = $request->file("audio");

        $extension = $file->getClientOriginalExtension();

        $timestamp = now()->format('YmdHis');
        $file->storeAs("public/audio", "audio_" . $timestamp . "." . $extension);

        return redirect("/audio/encrypt/result");
    }
}
