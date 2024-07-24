<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('upload');
// });

Route::resource('upload', UploadController::class);
Route::post('/upload/result', [UploadController::class, 'result']);
Route::get('/download/{filekey}', [DownloadController::class, 'index']);
