<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;

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

Route::get('/test/daraz', function(\App\Http\Services\DarazApiService $darazApiService){
//    dd($darazApiService->getCategoryTree());
    dd($darazApiService->createProduct());
    dd(response()->json($darazApiService->getCategoryAttributes()));
    $payload = "%3C%3Fxml+version%3D%221.0%22+encoding%3D%22UTF-8%22%3F%3E++%3CRequest%3E+++++++%3CProduct%3E++++++++++++%3CPrimaryCategory%3E6614%3C%2FPrimaryCategory%3E++++++++++++%3CSPUId%2F%3E++++++++++++%3CAssociatedSku%2F%3E+%3CImages%3E+++++++++++++%3CImage%3Ehttps%3A%2F%2Fmy-live-02.slatic.net%2Fp%2F765888ef9ec9e81106f451134c94048f.jpg%3C%2FImage%3E+++++++++++++%3CImage%3Ehttps%3A%2F%2Fmy-live-02.slatic.net%2Fp%2F9eca31edef9f05f7e42f0f19e4d412a3.jpg%3C%2FImage%3E++++%3C%2FImages%3E+++++++++%3CAttributes%3E+++++++++++++++++%3Cname%3Eapi+create+product+test+sample%3C%2Fname%3E+++++++++++++++++%3Cshort_description%3EThis+is+a+nice+product%3C%2Fshort_description%3E+++++++++++++++++%3Cbrand%3ERemark%3C%2Fbrand%3E+++++++++++++++++%3Cmodel%3Easdf%3C%2Fmodel%3E+++++++++++++++++%3Ckid_years%3EKids+%286-10yrs%29%3C%2Fkid_years%3E+++++++++%3Cdelivery_option_sof%3EYes%3C%2Fdelivery_option_sof%3E%09%09+++++%3C%21--should+be+set+as+%E2%80%98Yes%E2%80%99+only+for+products+to+be+delivered+by+seller--%3E+++++++%3C%2FAttributes%3E++++++++++++%3CSkus%3E+++++++++++++++++%3CSku%3E++++++++++++++++++++++%3CSellerSku%3Eapi-create-test-1%3C%2FSellerSku%3E++++++++++++++++++++++%3Ccolor_family%3EGreen%3C%2Fcolor_family%3E++++++++++++++++++++++%3Csize%3E40%3C%2Fsize%3E++++++++++++++++++++++%3Cquantity%3E1%3C%2Fquantity%3E++++++++++++++++++++++%3Cprice%3E388.50%3C%2Fprice%3E++++++++++++++++++++++%3Cpackage_length%3E11%3C%2Fpackage_length%3E++++++++++++++++++++++%3Cpackage_height%3E22%3C%2Fpackage_height%3E++++++++++++++++++++++%3Cpackage_weight%3E33%3C%2Fpackage_weight%3E++++++++++++++++++++++%3Cpackage_width%3E44%3C%2Fpackage_width%3E++++++++++++++++++++++%3Cpackage_content%3Ethis+is+what%27s";
//    dd(urldecode($payload));
    $xmlString = '<root><fruit>apple</fruit><fruit>banana</fruit></root>';
    $xml = simplexml_load_string($xmlString);
    $json = json_encode($xml);

    $xml_string = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>  <Request>       <Product>            <PrimaryCategory>6614</PrimaryCategory>            <SPUId/>            <AssociatedSku/> <Images>             <Image>https://my-live-02.slatic.net/p/765888ef9ec9e81106f451134c94048f.jpg</Image>             <Image>https://my-live-02.slatic.net/p/9eca31edef9f05f7e42f0f19e4d412a3.jpg</Image>    </Images>         <Attributes>                 <name>api create product test sample</name>                 <short_description>This is a nice product</short_description>                 <brand>Remark</brand>                 <model>asdf</model>                 <kid_years>Kids (6-10yrs)</kid_years>         <delivery_option_sof>Yes</delivery_option_sof>\t\t     <!--should be set as \u2018Yes\u2019 only for products to be delivered by seller-->       </Attributes>            <Skus>                 <Sku>                      <SellerSku>api-create-test-1</SellerSku>                      <color_family>Green</color_family>                      <size>40</size>                      <quantity>1</quantity>                      <price>388.50</price>                      <package_length>11</package_length>                      <package_height>22</package_height>                      <package_weight>33</package_weight>                      <package_width>44</package_width><package_content>this is what's in the box</package_content>                      <Images>                           <Image>http://sg.s.alibaba.lzd.co/original/59046bec4d53e74f8ad38d19399205e6.jpg</Image>                           <Image>http://sg.s.alibaba.lzd.co/original/179715d3de39a1918b19eec3279dd482.jpg</Image>                      </Images>                 </Sku>            </Skus>       </Product>  </Request>";
    $xml = simplexml_load_string($xml_string);
    $json = json_encode($xml);
    $array = json_decode($json, true);
    dd($array);
    dd();
//    dd($array);

    //====convert array to xml





    dd($darazApiService->getCategoryAttributes());
//    $daraz = new \App\Http\Controllers\DarazController();
//    dd($daraz->getToken());
//    $appKey = '500812';
//    $timestamp = $daraz->generateValidTimestamp();
//    $appSecret = 'oz7NCX1BYeIp3RwK7JehtLsj1pbChEzb';
//    $signMethod = 'sha256';
//    $apiName = '/auth/token/create';
//    $data = [
//        'access_token' => $appSecret,
//        'app_key' => $appKey,
//        'sign_method' => $signMethod,
//        'code' => '4_500812_Z6TB1Vs2BU5uvUtiY1YvJT4m338',
//        'timestamp' => $timestamp,
//    ];
//    $data = [ // routes/web.php:56
//        "Host" => '<calculated when request is sent>',
//        "app_key" => "500812",
//  "timestamp" => "1678547394351",
//  "sign_method" => "sha256",
////  "sign" => "f6867d01edb6d3d65d947291c60e69f783ab26ee894de54b522422b3e8739b6b",
//  "code" => "4_500812_Z6TB1Vs2BU5uvUtiY1YvJT4m338"
//];
//    $sign = $daraz->signApiRequest($data, $apiName, );
//
//    dd($data['timestamp'], $sign);
//    dd($timestamp, $sign);

});
