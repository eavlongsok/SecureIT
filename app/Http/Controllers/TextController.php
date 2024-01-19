<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $encryptedText = $this->performEncryption($request->input('text'));

        return view('text.encrypt-result', compact('encryptedText'));
    }

    public function decryptText(Request $request)
    {
        $decryptedText = $this->performDecryption($request->input('text'));

        return view('text.decrypt-result', compact('decryptedText'));
    }

    public function showText()
    {
        return view('text.text');
    }

    private function performEncryption($text)
    {
        return base64_encode($text);
    }

    private function performDecryption($text)
    {
        return base64_decode($text);
    }
}
