<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class ImageController extends Controller
{
    public function showImagePage()
    {
        return view('image.image'); // Adjust the path to match your actual folder structure
    }



    public function showEncryptForm()
    {
        return view('image.encrypt');
    }

    public function showDecryptForm()
    {
        return view('image.decrypt');
    }
    public function encrypt(Request $request)
{



    $validate = Validator::make($request->all(), [
        'key' => 'required|string|min:16|max:16',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        "key" => "required|size:16"
    ], [
        "image.required" => "Please upload a image file or capture one",
        "image.mimes" => "The image must be of type jpeg,png,jpg,gif or svg",
        "image.max" => "The image must be less than 2048",
        "key.required" => "Please enter a key",
        "key.size" => "The key must be 16 characters long"
    ]);

    if ($validate->fails()) {
        return redirect("/image/encrypt")->withErrors($validate);
    }

    // save file from request as its own type
    $file = $request->file("image");
    $key = $request->input("key");
    // get file extension
    $extension = $file->getClientOriginalExtension();
    // store file
    $file->storeAs("public", "image_to_encrypt." . $extension);

    $output = shell_exec('python "' . base_path() . '\scripts\main.py" -t encrypt -f image -k "' . $key . '" -p "' . base_path() . '\storage\app\public\image_to_encrypt.' . $extension . '"');

    return Redirect::route('image.result')->with([
        "type" => "encryption",
        "key" => $key,
        "image_path" => asset("storage/" . $filePath),  
    ]);
}
public function decrypt(Request $request)
{


    $validate = Validator::make($request->all(), [
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        "key" => "required|size:16",
        'key' => 'required|string|min:16|max:16'
    ], [
        "image.required" => "Please upload a image file or capture one",
        "image.mimes" => "The image must be of type jpeg,png,jpg,gif or svg",
        "image.max" => "The image must be less than 2048",
        "key.required" => "Please enter a key",
        "key.size" => "The key must be 16 characters long"
    ]);
    if ($validate->fails()) {
        return redirect("/image/decrypt")->withErrors($validate);
    }


    $file = $request->file("image");
    $key = $request->input("key");
    // get file extension
    $extension = $file->getClientOriginalExtension();
    // store file
    $file->storeAs("public", "image_to_decrypt." . $extension);


    $output = shell_exec('python "' . base_path() . '\scripts\main.py" -t decrypt -f image -k "' . $key . '" -p "' . base_path() . '\storage\app\public\image_to_decrypt.' . $extension . '"');

    return Redirect::route('image.result')->with(["type" => "decryption", "key" => $key, "image_path" => 'public/decrypted_image.' . $extension]);
}

public function showResult()
{
    if (session()->has("type") && session()->has("key") && session()->has("image_path")) {
        return view('image.result', [
            "type" => session("type"),
            "key" => session("key"),
            "image_path" => session("image_path")]);
    }
    return Redirect::route('image.result');
}



}