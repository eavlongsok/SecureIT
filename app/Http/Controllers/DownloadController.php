<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    //
    public function download(Request $request)
    {
        $path = $request->input('path');
        // check if file exists
        if (Storage::exists($path)) {
            // return file
            return Storage::download($path);
        }
        // return error
        return response()->json(['error' => 'File not found', 'path' => $path], 404);
    }
}
