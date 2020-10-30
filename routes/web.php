<?php

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
	return redirect()->route("home");
    // return view('welcome');
});

Auth::routes();

Route::get("/stock/delete_stock","StockController@delete_stock")->name('stock.delete_stock');
Route::get("/stock/print_stock","StockController@print_stock")->name('stock.print_stock');
Route::get("/stock/print_invoice","StockController@print_invoice")->name('stock.print_invoice');


Route::resources([
    'barangmasuk' => 'BarangMasukController',
    'barangkeluar' => 'BarangKeluarController',
    'barangretur' => 'BarangReturController',
    'admin' => 'AdminController',
    'category' => 'CategoryController',
    'merk' => 'MerkController',
    'models'=> 'ModelsController',
    "stock" => 'StockController'
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post("/ajax/updatestockprice","AjaxController@updatestockprice")->name('ajax.updatestockprice');
Route::post("/ajax/updatetotalstockprice","AjaxController@updatetotalstockprice")->name('ajax.updatetotalstockprice');
Route::post("/ajax/get_merk","AjaxController@get_merk")->name('ajax.get_merk');
Route::post("/ajax/get_models","AjaxController@get_models")->name('ajax.get_models');

