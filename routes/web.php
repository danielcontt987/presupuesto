<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CashCutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PointSaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RestaurantController;
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

Route::get('/mi-perfil', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/proyectos', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/restaurante', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/estadisticas', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/planificador', function () {
    return view('home');
})->middleware('auth.user');

Route::get('/cocina', function () {
    return view('home');
})->middleware('auth.user');

//Not found
// Route::get('/{any}', function () {
//     return view('home'); // o la vista que uses
// })->where('any', '.*');

//Rutas

Route::prefix('user')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/login-qr', [UserController::class, 'loginToQr']);
    Route::post('/consult-user', [UserController::class, 'consultUser']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/update-face', [UserController::class, 'registerFace']);
    Route::post('/login-face', [UserController::class, 'loginFace']);
})->middleware('auth.user');

Route::prefix('setting')->group(function () {
    Route::post('/get', [SettingController::class, 'get']);
    Route::post('/update-part-1', [SettingController::class, 'updateInfo']);
    Route::post('/update-ubication', [SettingController::class, 'updateUbication']);
})->middleware('auth.user');

Route::prefix('area')->group(function () {
    Route::post('/get', [AreaController::class, 'get']);
    Route::post('/consult-info', [AreaController::class, 'consultAreadetails']);
    Route::post('/store-permission', [AreaController::class, 'storePermission']);
})->middleware('auth.user');

Route::prefix('module')->group(function () {
    Route::post('/list', [ModuleController::class, 'list']);
})->middleware('auth.user');

Route::prefix('module')->group(function () {
    Route::post('/store', [ModuleController::class, 'store']);
    Route::post('/update', [ModuleController::class, 'update']);
})->middleware('auth.user');

Route::prefix('category')->group(function () {
    Route::post('/store', [CategoryController::class, 'store']);
    Route::post('/list', [CategoryController::class, 'list']);
})->middleware('auth.user');

Route::prefix('product')->group(function () {
    Route::post('/store', [ProductController::class, 'store']);
    Route::post('/list', [ProductController::class, 'list']);
    Route::post('/search', [ProductController::class, 'search']);
    Route::post('/list-by-category', [ProductController::class, 'listByCategory']);
})->middleware('auth.user');

Route::prefix('salebox')->group(function () {
    Route::post('/list', [SaleBoxController::class, 'list']);
    Route::post('/store', [SaleBoxController::class, 'store']);
})->middleware('auth.user');

Route::prefix('cashcut')->group(function () {
    Route::post('/get', [CashCutController::class, 'get']);
    Route::post('/store', [CashCutController::class, 'store']);
})->middleware('auth.user');

Route::prefix('sale')->group(function () {
    Route::post('/store', [PointSaleController::class, 'store']);
})->middleware('auth');

Route::prefix('qr')->group(function () {
    Route::get('/generate', [UserController::class, 'qrGenerate']);
})->middleware('auth');


Route::prefix('restaurant')->group(function () {
    Route::post('/list', [RestaurantController::class, 'list']);
    Route::post('/items', [RestaurantController::class, 'items']);
    Route::post('/categories', [RestaurantController::class, 'listCategories']);
    Route::post('/add-to-account', [RestaurantController::class, 'addToAccount']);
    Route::get('/list-item-cook', [RestaurantController::class, 'listItemCook']);
    Route::post('/update-order', [RestaurantController::class, 'updateItemStatus']);
});

Route::prefix('pointsales')->group(function () {
    Route::get('/list', [PointSaleController::class, 'list']);
    Route::get('/get/{id}', [PointSaleController::class, 'get']);
});

Route::prefix('projects')->group(function () {
    Route::get('/list', [ProjectController::class, 'list']);
    Route::get('/get', [ProjectController::class, 'get']);
    Route::post('/update-card', [ProjectController::class, 'updateCard']);
});

Route::get('/print-ticket/{sale}', [PointSaleController::class, 'print']);
