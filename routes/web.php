<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;

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

Route::get('/data/daraz', function(Request $request){
    dd( $request->all());
});

Route::get('/test/daraz', function(){

    $daraz = new \App\Http\Controllers\DarazController();
    dd($daraz->getToken());
    $appKey = '500812';
    $timestamp = $daraz->generateValidTimestamp();
    $appSecret = 'oz7NCX1BYeIp3RwK7JehtLsj1pbChEzb';
    $signMethod = 'sha256';
    $apiName = '/auth/token/create';
    $data = [
        'access_token' => $appSecret,
        'app_key' => $appKey,
        'sign_method' => $signMethod,
        'code' => '4_500812_Z6TB1Vs2BU5uvUtiY1YvJT4m338',
        'timestamp' => $timestamp,
    ];
    $data = [ // routes/web.php:56
        "Host" => '<calculated when request is sent>',
        "app_key" => "500812",
  "timestamp" => "1678547394351",
  "sign_method" => "sha256",
//  "sign" => "f6867d01edb6d3d65d947291c60e69f783ab26ee894de54b522422b3e8739b6b",
  "code" => "4_500812_Z6TB1Vs2BU5uvUtiY1YvJT4m338"
];
    $sign = $daraz->signApiRequest($data, $apiName, );

    dd($data['timestamp'], $sign);
    dd($timestamp, $sign);

});
