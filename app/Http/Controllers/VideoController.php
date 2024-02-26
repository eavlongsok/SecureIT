<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function showEncryptForm()
    {
        return view('video.encrypt');
    }

    public function showDecryptForm()
    {
        return view('video.decrypt');
    }

    public function encrypt(Request $request)
    {

        //        dd($request, $request->file("video")->getMimeType(), $request->file("video")->getClientMimeType());

        // $validate = Validator::make($request->all(), [
        //     "video" => "required|mimes:mp4,webm,mkv|max:10240",
        //     "key" => "required|size:16"
        // ], [
        //     "video.required" => "Please upload a video file or record one",
        //     "video.mimes" => "The video must be of type mp4 or webm or mkv",
        //     "video.max" => "The video must be less than 10mb",
        //     "key.required" => "Please enter a key",
        //     "key.size" => "The key must be 16 characters long"
        // ]);

        // if ($validate->fails()) {
        //     return redirect("/video/encrypt")->withErrors($validate);
        // }

        // save file from request as its own type
        $file = $request->file("video");
        $key = $request->input("key");
        $inputPath = $request->input("path");
        $inputPath = trim($inputPath, '"');

        if (!empty($file)) {
            // get file extension
            $extension = $file->getClientOriginalExtension();
            // store file
            $file->storeAs("public", "video_to_encrypt." . $extension);
            // dd("python '" . base_path() . "/scripts/main.py' -t encrypt -f video -k '" . $key . "' -p '" . base_path() . "/storage/app/public//video_to_encrypt." . $extension . "'");
            $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t encrypt -f video -k "' . $key . '" -p "' . base_path() . '/storage/app/public/video_to_encrypt.' . $extension . '"');

            // return Redirect::route('video.result')->with(["type" => "encryption", "key" => $key, "video_path" => 'public/encrypted_video.' . $extension]);
            return Redirect::route('video.result')->with(["type" => "encryption", "key" => $key, "video_path" => 'public/encrypted_video.mkv']);
        } else if (strlen($inputPath) != 0) {
            // dd("python '" . base_path() . "/scripts/main.py' -t encrypt -f video -k '" . $key . "' -p '" . $inputPath . "'");
            $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t encrypt -f video -k "' . $key . '" -p "' . $inputPath . '"');
            // dd($output);
            return Redirect::route('video.result')->with(["type" => "encryption", "key" => $key, "video_path" => 'public/encrypted_video.mkv']);
        } else {
            return redirect("/video/encrypt")->withErrors(["error" => "Please upload a video file or record one"]);
        }
        //        dd('python "' . base_path() . '/scripts/main.py" -t encrypt -f video -k "' . $key . '" -p "' . base_path() . '/storage/app/public/video_to_encrypt.' . $extension . '"');
        // $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t encrypt -f video -k "' . $key . '" -p "' . base_path() . '/storage/app/public/video_to_encrypt.' . $extension . '"');

    }

    public function decrypt(Request $request)
    {

        //        dd($request->files, $request->file("video")->getClientMimeType(), $request->file("video")->getMimeType());
        // $validate = Validator::make($request->all(), [
        //     "video" => "required|max:10240",
        //     "key" => "required|size:16"
        // ], [
        //     "video.required" => "Please upload a video file or record one",
        //     "video.max" => "The video must be less than 10mb",
        //     "key.required" => "Please enter a key",
        //     "key.size" => "The key must be 16 characters long"
        // ]);
        // if ($validate->fails()) {
        //     return redirect("/video/decrypt")->withErrors($validate);
        // }


        $file = $request->file("video");
        $key = $request->input("key");
        $inputPath = $request->input("path");
        $inputPath = trim($inputPath, '"');

        if (!empty($file)) {
            // get file extension
            $extension = $file->getClientOriginalExtension();
            // store file
            $file->storeAs("public", "video_to_decrypt." . $extension);

            //        dd('python "' . base_path() . '/scripts/main.py" -t decrypt -f video -k "' . $key . '" -p "' . base_path() . '/storage/app/public/video_to_decrypt.' . $extension . '"');
            $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t decrypt -f video -k "' . $key . '" -p "' . base_path() . '/storage/app/public/video_to_encrypt.' . $extension . '"');

            // return Redirect::route('video.result')->with(["type" => "decryption", "key" => $key, "video_path" => 'public/decrypted_video.' . $extension]);
            return Redirect::route('video.result')->with(["type" => "decryption", "key" => $key, "video_path" => 'public/decrypted_video.mkv']);
        } else if (strlen($inputPath) != 0) {
            $output = shell_exec('python "' . base_path() . '/scripts/main.py" -t decrypt -f video -k "' . $key . '" -p "' . $inputPath . '"');
            return Redirect::route('video.result')->with(["type" => "decryption", "key" => $key, "video_path" => 'public/decrypted_video.mkv']);
        } else {
            return redirect("/video/decrypt")->withErrors(["error" => "Please upload a video file or record one"]);
        }
    }

    public function showResult()
    {
        if (session()->has("type") && session()->has("key") && session()->has("video_path")) {
            return view('video.result', [
                "type" => session("type"),
                "key" => session("key"),
                "video_path" => session("video_path")
            ]);
        }
        return Redirect::route('video.view');
    }

    public function showVideo()
    {
        return view('video.video');
    }
}