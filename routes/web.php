<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CashCutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleBoxController;
use App\Http\Controllers\SettingController;
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


Route::get('/admin', function () {
    return view('home');
})->middleware('auth.user');
    
Route::get('/inicio', function () {
    return view('home');
})->middleware('auth.user');
    
Route::get('/configuracion', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/areas', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/detalle-del-area', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/crear-modulos', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/punto-de-venta', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/clientes', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/crear-cliente', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/productos', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/crear-producto', function () {
    return view('home');
})->middleware('auth.user');

//Rutas

Route::prefix('user')->group(function(){
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/consult-user', [UserController::class, 'consultUser']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::prefix('setting')->group(function(){
    Route::post('/get', [SettingController::class, 'get']);
    Route::post('/update-part-1', [SettingController::class, 'updateInfo']);
});

Route::prefix('area')->group(function(){
    Route::post('/get', [AreaController::class, 'get']);
    Route::post('/consult-info', [AreaController::class, 'consultAreadetails']);
    Route::post('/store-permission', [AreaController::class, 'storePermission']);

});

Route::prefix('module')->group(function(){
    Route::post('/list', [ModuleController::class, 'list']);
});

Route::prefix('module')->group(function(){
    Route::post('/store', [ModuleController::class, 'store']);
    Route::post('/update', [ModuleController::class, 'update']);
});

Route::prefix('category')->group(function(){
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/list', [CategoryController::class, 'list']);
});

Route::prefix('product')->group(function(){
    Route::post('/store', [ProductController::class, 'store']);
    Route::post('/list', [ProductController::class, 'list']);
});

Route::prefix('salebox')->group(function(){
    Route::post('/list', [SaleBoxController::class, 'list']);
    Route::post('/store', [SaleBoxController::class, 'store']);
});

Route::prefix('cashcut')->group(function(){
    Route::post('/get', [CashCutController::class, 'get']);
    Route::post('/store', [CashCutController::class, 'store']);
});

Route::get('/print-ticket', [ModuleController::class, 'print'])->name('print.ticket');