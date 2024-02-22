<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TextController;
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
})->name('welcome');


// Text
Route::prefix('text')->group(function () {
    // Display forms
    Route::get('/encrypt', [TextController::class, 'showEncryptForm'])->name('encrypt.form');
    Route::get('/decrypt', [TextController::class, 'showDecryptForm'])->name('decrypt.form');

    // Encryption & decryption
    Route::post('/encrypt', [TextController::class, 'encryptText'])->name('encrypt.text');
    Route::post('/decrypt', [TextController::class, 'decryptText'])->name('decrypt.text');

    Route::get('/result', [TextController::class, 'showResult'])->name('text.result');
    Route::get('/deresult', [TextController::class, 'showDeResult'])->name('text.decrypt-result');
    // Handling results
    // Route::post('/decryption', [TextController::class, 'decryptResult'])->name('decrypt.result');
    // Route::post('/encryption', [TextController::class, 'encryptResult'])->name('encrypt.result');

    // Show page
    Route::get('/', [TextController::class, 'showText'])->name('text.view');
});

// Image
Route::prefix('image')->group(function () {
    Route::get('/encrypt', [ImageController::class, 'showEncryptForm'])->name('image.encrypt.form');
    Route::post('/encrypt', [ImageController::class, 'encrypt'])->name('image.encrypt');

    Route::get('/decrypt', [ImageController::class, 'showDecryptForm'])->name('image.decrypt.form');
    Route::post('/decrypt', [ImageController::class, 'decrypt'])->name('image.decrypt');

    Route::get('/result', [ImageController::class, 'showResult'])->name('image.result');

    // Show page
    Route::get('/', [ImageController::class, 'showImage'])->name('image.view');
});

// Audio
Route::prefix('audio')->group(function () {
    Route::get('/encrypt', [AudioController::class, 'showEncryptForm'])->name('audio.encrypt.form');
    Route::post('/encrypt', [AudioController::class, 'encrypt'])->name('audio.encrypt');
    Route::get('/encrypt/result', [AudioController::class, 'showAudioResult'])->name('audio.encrypt.result');

    Route::get('/decrypt', [AudioController::class, 'showDecryptForm'])->name('audio.decrypt.form');
    Route::post('/decrypt', [AudioController::class, 'decrypt'])->name('audio.decrypt');
    Route::get('/decrypt/result', [AudioController::class, 'showAudioResult'])->name('audio.decrypt.result');

    // Show page
    Route::get('/', [AudioController::class, 'showAudio'])->name('audio.view');
});

// Video
Route::prefix('video')->group(function () {
    Route::get('/encrypt', [VideoController::class, 'showEncryptForm'])->name('video.encrypt.form');
    Route::get('/decrypt', [VideoController::class, 'showDecryptForm'])->name('video.decrypt.form');

    Route::post('/encrypt', [VideoController::class, 'encrypt'])->name('video.encrypt');

    Route::post('/decrypt', [VideoController::class, 'decrypt'])->name('video.decrypt');

    Route::get('/result', [VideoController::class, 'showResult'])->name('video.result');

    // Show page
    Route::get('/', [VideoController::class, 'showVideo'])->name('video.view');
});

Route::post("/download", [DownloadController::class, "download"])->name("download");