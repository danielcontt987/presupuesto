<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
//     return view('welcome');
// });
Route::redirect('/', 'login');
Route::get('/login', function () {
    return view('welcome');
});

Route::prefix('user')->group(function(){
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/admin', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/inicio', function () {
    return view('home');
})->middleware('auth.user');