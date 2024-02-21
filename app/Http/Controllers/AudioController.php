<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\ShellExec;

class AudioController extends Controller
{
    public function showEncryptForm()
    {
        return view('audio.encrypt');
    }

    public function encrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'audio' => ['required', 'file', 'mimes:wav', 'max:102400', function ($attribute, $value, $fail) {
                // Open the WAV file
                $wavFile = fopen($value->getPathname(), 'rb');
                
                // Read the WAV header to determine the number of channels
                $header = fread($wavFile, 44); // WAV header is 44 bytes
                fclose($wavFile);
        
                // Extract the number of channels from the header
                $numberOfChannels = ord($header[22]); // Byte 23 contains the number of channels
        
                // Check if the WAV file is mono-channel (number of channels = 1)
                if ($numberOfChannels !== 1) {
                    $fail('The audio must be mono-channel.');
                }
            }],
            'key' => 'required|size:16',
        ], [
            'audio.required' => 'The audio field is required.',
            'audio.file' => 'The audio must be a file.',
            'audio.mimes' => 'The audio must be a WAV file.',
            'audio.max' => 'The audio may not be greater than 100 MB.',
            'key.required' => 'The key field is required.',
            'key.size' => 'The key must be exactly 16 characters.',
        ]);
        
    
        if ($validate->fails()) {
            return redirect("/aud/encrypt")->withErrors($validate);
        }
    
        // Save audio file from request
        $file = $request->file("audio");
        $key = $request->input("key");
        
        $extension = $file->getClientOriginalExtension();
        $file->storeAs("public", "audio_to_encrypt." . $extension);
    
        $output = shell_exec('py "' . base_path() . '\scripts\main.py" -t encrypt -f audio -k "' . $key . '" -p "' . base_path() . '\storage\app\public\audio_to_encrypt.' . $extension . '"');

        // Redirect to result page with encryption details
        return Redirect::route('audio.result')->with(["type" => "encryption", "key" => $key, "audio_path" => 'public/encrypted_audio.' . $extension]);
    }
    

    public function showDecryptForm()
    {
        return view('audio.decrypt');
    }

    public function decrypt(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "audio" => "required|max:10240", 
            "key" => "required|size:16"
        ], [
            "audio.required" => "Please upload an audio file",
            "audio.max" => "The audio file must be less than 10MB",
            "key.required" => "Please enter a key",
            "key.size" => "The key must be 16 characters long"
        ]);
        if ($validate->fails()) {
            return redirect("/audio/decrypt")->withErrors($validate);
        }

        $file = $request->file("audio");
        $key = $request->input("key");
        $extension = $file->getClientOriginalExtension();
        $file->storeAs("public", "audio_to_decrypt." . $extension); 
        $output = shell_exec('py "' . base_path() . '\scripts\main.py" -t decrypt -f audio -k "' . $key . '" -p "' . base_path() . '\storage\app\public\audio_to_decrypt.' . $extension . '"');

        return Redirect::route('audio.result')->with(["type" => "decryption", "key" => $key, "audio_path" => 'public/decrypted_audio.' . $extension]);
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
