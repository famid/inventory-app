<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WarehouseController;
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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->prefix('/product')->as('product.')->group(function () {
    Route::get('/list', [ProductController::class, 'getList'])->name('list');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/delete/{id}', [ProductController::class, 'delete'])->name('destroy');
});

Route::middleware('auth')->prefix('/category')->as('category.')->group(function () {
    Route::get('/list', [CategoryController::class, 'getList'])->name('list');
});

Route::middleware('auth')->prefix('/subcategory')->as('subcategory.')->group(function () {
    Route::get('/list', [SubcategoryController::class, 'getList'])->name('list');
});

Route::middleware('auth')->prefix('/warehouse')->as('warehouse.')->group(function () {
    Route::get('/index', [WarehouseController::class, 'index'])->name('index');
    Route::get('/list', [WarehouseController::class, 'getList'])->name('list');
    Route::delete('/delete/{id}', [WarehouseController::class, 'destroy'])->name('destroy');
    Route::get('/create', [WarehouseController::class, 'create'])->name('create');
    Route::post('/store', [WarehouseController::class, 'store'])->name('store');
});

Route::get('/location/{warehouse_id}', function ($warehouse_id) {
    dd($warehouse_id);
});
