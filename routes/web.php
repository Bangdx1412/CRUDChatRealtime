<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('authentication')->group(function(){
    Route::get('/list-user', [ChatController::class, 'chatPublic'])->name('chatPublic');
    Route::post('/nhanTin', [ChatController::class, 'nhanTin'])->name('nhanTin');


    Route::get('danh-sach-user',[UserController::class,'danhSachUsers'])->name('danh-sach-user');
    Route::post('addUSer',[UserController::class,'addUSer'])->name('addUSer');
    Route::post('detailUser',[UserController::class,'detailUser'])->name('detailUser');
    Route::post('updateUser',[UserController::class,'updateUser'])->name('updateUser');
});
