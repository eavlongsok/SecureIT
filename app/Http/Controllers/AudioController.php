<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function showEncryptForm()
    {
        return view('audio.encrypt');
    }

    public function encrypt(Request $request)
    {
        $file = $request->file("audio");

        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $timestamp = now()->format('YmdHis');
            $filename = "audio_" . $timestamp . "." . $extension;
            $file->storeAs("public/audio", $filename);

            return redirect("/audio/encrypt/result")->with('status', 'Audio encrypted successfully!');
        }

        return back()->withErrors(['audio' => 'Please upload a valid audio file.']);
    }

    public function showDecryptForm()
    {
        return view('audio.decrypt');
    }

    public function decrypt(Request $request)
    {
        $file = $request->file("audio");

        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $timestamp = now()->format('YmdHis');
            $filename = "audio_" . $timestamp . "." . $extension;
            $file->storeAs("public/audio", $filename);

            return redirect("/audio/decrypt/result")->with('status', 'Audio decrypted successfully!');
        }

        return back()->withErrors(['audio' => 'Please upload a valid audio file.']);
    }

    public function showAudioResult()
    {
        return view('audio.result');
    }

    public function showAudio()
    {
        return view('audio.audio');
    }
}
