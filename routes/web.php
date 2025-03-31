<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Events\DiagnosingHealth;

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

Route::get('/', [\App\Http\Controllers\UploadController::class, 'index']);
Route::get('/config', [\App\Http\Controllers\UploadController::class, 'config']);

Route::withoutMiddleware('web')->middleware('upload')->post('/', [\App\Http\Controllers\UploadController::class, 'upload']);
