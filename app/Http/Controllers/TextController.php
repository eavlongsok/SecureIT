<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

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
        $validated = $this->validateTextOrFile($request);

        if ($request->hasFile('file')) {
            $text = file_get_contents($request->file('file')->getRealPath());
        } else {
            $text = $request->input('text');
        }

        $encryptedText = Crypt::encryptString($text);

        return view('text.encrypt-result', compact('encryptedText'));
    }

    public function decryptText(Request $request)
    {
        $validated = $this->validateTextOrFile($request);

        try {
            if ($request->hasFile('file')) {
                $text = file_get_contents($request->file('file')->getRealPath());
                $decryptedText = Crypt::decryptString($text);
            } else {
                $decryptedText = Crypt::decryptString($request->input('text'));
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Decryption failed. Please ensure the encrypted content is correct.']);
        }

        return view('text.decrypt-result', compact('decryptedText'));
    }

    public function showText()
    {
        return view('text.text');
    }

    private function validateTextOrFile(Request $request)
    {
        return $request->validate([
            'encryptionKey' => 'required|min:5',
            'text' => 'required_without:file|min:8',
            'file' => 'required_without:text|file|mimes:txt|max:1024',
        ]);
    }
    
}
