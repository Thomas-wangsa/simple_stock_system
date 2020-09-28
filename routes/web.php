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
    return view('welcome');
});

Auth::routes();


Route::resources([
    'barangmasuk' => 'BarangMasukController',
    'barangkeluar' => 'BarangKeluarController'
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post("/ajax/updatestockprice","AjaxController@updatestockprice")->name('ajax.updatestockprice');
Route::post("/ajax/updatetotalstockprice","AjaxController@updatetotalstockprice")->name('ajax.updatetotalstockprice');