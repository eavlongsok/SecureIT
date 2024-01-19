<?php

use App\Http\Controllers\VideoController;
use App\Http\Controllers\AudioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("/audio")->group(function () {
    Route::get("encrypt", function () {
        return view("audio.encrypt");
    });

    Route::post("encrypt", [AudioController::class, "encrypt"]);
});

Route::prefix("/video")->group(function () {
    Route::get("encrypt", function () {
        return view("video.encrypt");
    });

    Route::post("encrypt", [VideoController::class, "encrypt"]);
});
