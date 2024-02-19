<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TextController extends Controller
{
    public function showEncryptForm()
    {
        return view('text.encrypt');
    }

    public function showDecryptForm()
    {
        return view('text.decrypt');
    }

    public function encryptText(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "text" => "required|mimes:txt,csv,doc,docx|max:1024", 
            "key" => "required|size:16"
        ], [
            "text.required" => "Please upload a text file",
            "text.mimes" => "The text must be of type txt, csv, doc, or docx",
            "text.max" => "The text file must be less than 1MB",
            "key.required" => "Please enter a key",
            "key.size" => "The key must be 16 characters long"
        ]);
    
        if ($validate->fails()) {
            return redirect("/text/encrypt")->withErrors($validate);
        }
    
        $file = $request->file("text");
        $key = $request->input("key");
        $extension = $file->getClientOriginalExtension();
        $text_path = $file->storeAs("public", "text_to_encrypt." . $extension);
        
        $output = shell_exec('python "' . base_path() . '\scripts\main.py" -t encrypt -f text -k "' . $key . '" -p "' . base_path() . '\storage\app\public\text_to_encrypt.' . $extension . '"');
    
        return Redirect::route('encrypt.result')->with(["type" => "encryption", "key" => $key, "text_path" => $text_path]);
    }
    

    public function decryptText(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "textFile" => "required|file|mimes:txt,csv,doc,docx|max:2048", 
            "key" => "required|string|size:16", 
        ], [
            "textFile.required" => "Please upload a text file to decrypt.",
            "textFile.file" => "The uploaded file must be a valid file.",
            "textFile.mimes" => "Only txt, csv, doc, and docx files are allowed.",
            "textFile.max" => "The text file must not exceed 2MB.",
            "key.required" => "A decryption key is required.",
            "key.size" => "The decryption key must be exactly 16 characters.",
        ]);
    
        if ($validate->fails()) {
            return redirect()->route('decrypt.form')->withErrors($validate);
        }
    
        $file = $request->file('textFile');
        $key = $request->input('key');
        $filePath = $file->getRealPath();
        $decryptedDataPath = "/path/to/decrypted/file"; 
    
        $command = 'python "' . base_path() . '/scripts/decrypt.py" --key "' . $key . '" --input "' . $filePath . '" --output "' . $decryptedDataPath . '"';
        $output = shell_exec($command);
    
        if (!empty($output)) {
            return Redirect::route('decrypt.result')->with([
                'message' => 'Decryption successful!',
                'decryptedData' => $decryptedDataPath
            ]);
        } else {
            return redirect()->route('decrypt.form')->withErrors(['message' => 'Decryption failed. Please check your input and try again.']);
        }
    }
    

    public function encryptResult(Request $request)
    {
        if (session()->has("type") && session()->has("key") && session()->has("text_path")) {
            return view('text.result', [
                "type" => session("type"),
                "key" => session("key"),
                "text_path" => session("text_path")
            ]);
        }
        return Redirect::route('text.view');
    }
    
    public function decryptResult(Request $request)
    {
        if (session()->has("type") && session()->has("key") && session()->has("text_path")) {
            return view('text.result', [
                "type" => session("type"),
                "key" => session("key"),
                "text_path" => session("text_path")
            ]);
        }
        return Redirect::route('text.view');
    }

    public function showText()
    {
        return view('text.text');
    }
}
