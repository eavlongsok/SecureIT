<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImageEncryptionController;
use App\Http\Controllers\VideoController;
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
    Route::get("decrypt", function () {
        return view("video.decrypt");
    });

    Route::post("encrypt", [VideoController::class, "encrypt"]);
    Route::post("decrypt", [VideoController::class, "decrypt"]);
});

// Display forms
Route::get('/text/encrypt', [TextController::class, 'showEncryptForm'])->name('encrypt.form');
Route::get('/text/decrypt', [TextController::class, 'showDecryptForm'])->name('decrypt.form');

// Process encryption and decryption
Route::post('/text/encrypt', [TextController::class, 'encryptText'])->name('encrypt.text');
Route::post('/text/decrypt', [TextController::class, 'decryptText'])->name('decrypt.text');

Route::post('/text/decryption', [TextController::class, 'decryptResult'])->name('decrypt.result');
Route::post('/text/encryption', [TextController::class, 'encryptResult'])->name('encrypt.result');

// Show text page
Route::get('/text', [TextController::class, 'showText'])->name('text.view');




//Image
Route::get('/image', [ImageController::class, 'showImagePage'])->name('image.show');
Route::post('/image/upload', [ImageEncryptionController::class, 'uploadImage'])->name('image.upload');

Route::prefix('/image')->name('image.')->group(function () {
    Route::get('encrypt', function () {
        return view('image.encrypt_image');
    })->name('encrypt');

    Route::post('encrypt', [ImageController::class, 'encrypt'])->name('encrypt.post');
});
//Image decryption
Route::prefix('/image')->name('image.')->group(function () {
    Route::get('decrypt', function () {
        return view('image.decrypt_image');
    })->name('decrypt');
   
    Route::post('decrypt', [ImageController::class, 'decrypt'])->name('decrypt.post');
});
