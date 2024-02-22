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
            "key" => "required|size:16"
        ], [
            "key.required" => "Please enter a key",
            "key.size" => "The key must be 16 characters long"
        ]);
    
        // Custom validation for text or textFile
        $textProvided = $request->input('text') !== null && trim($request->input('text')) !== '';
        // $fileProvided = $request->hasFile('textFile');
    
        if ($validate->fails()) {
            return redirect("/text/encrypt")->withErrors($validate);
        }

        // if (!($textProvided xor $fileProvided)) { 
        //     $validate->errors()->add('text', 'Please provide either text or a text file, but not both.');
        // }
    
        if ($validate->fails() || $validate->errors()->isNotEmpty()) {
            return redirect("/text/encrypt")->withErrors($validate);
        }
    
        // if ($fileProvided) {
        //     $file = $request->file("textFile");
        //     $extension = $file->getClientOriginalExtension();
        //     $text_path = $file->storeAs("public", "text_to_encrypt." . $extension);
        // } else {
        //     $text = $request->input('text');
        // }

        $text = $request->input('text');
        $key = $request->input("key");
    
        $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t encrypt -f text -k "' . $key . '" -p "' . $text . '"');
        return Redirect::route('text.result')->with(["type" => "encryption", "key" => $key, "text" => $text, 'path/to/text_from_input']);
    }
    
    

    public function decryptText(Request $request)
    {
        $validate = Validator::make($request->all(), [
            // "textFile" => "required|file|mimes:txt,csv,doc,docx|max:2048", 
            "key" => "required|string|size:16", 
        ], [
            "textFile.required" => "Please upload a text file to decrypt.",
            "textFile.file" => "The uploaded file must be a valid file.",
            // "textFile.mimes" => "Only txt, csv, doc, and docx files are allowed.",
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
            return Redirect::route('text.ecrypt.result')->with([
                'message' => 'Decryption successful!',
                'decryptedData' => $decryptedDataPath
            ]);
        } else {
            return redirect()->route('decrypt.form')->withErrors(['message' => 'Decryption failed. Please check your input and try again.']);
        }
    }
    
    public function showResult(Request $request)
    {
        if (session()->has("type") && session()->has("key")) {
            $type = session("type");
            $key = session("key");
            $text = session("text");
            // $textFile = session("text");
            $textPath = session("text_path");
    
            $encryptedText = null;
    
            // if (file_exists(storage_path('app/' . $textPath))) {
            //     $encryptedText = file_get_contents(storage_path('app/' . $textPath));
            // } else {
            //     $encryptedText = "The encrypted text could not be found or is not accessible.";
            // }
    
            return view('text.result', [
                "type" => $type,
                "key" => $key,
                "text" => $text,
                // "textfile" => $textFile,
                "encryptedText" => $encryptedText 
            ]);
        }
        return Redirect::route('text.view'); 

    }
    

    public function showText()
    {
        return view('text.text');
    }
}
