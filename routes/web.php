<?php

use Illuminate\Support\Facades\Auth;
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
//Route::get('/', function () {
//    return view('welcome');
//
//})->middleware(['auth.shopify'])->name('home');

Route::group(['middleware'=>['auth.shopify']], function () {
    // customer routes
//->middleware(['cors'])
    Route::get('/order-sync', 'OrderController@order_sync')->name('order-sync');
    Route::get('/product-sync', 'ProductController@product_sync')->name('product-sync');
    Route::get('/collection-sync', 'CollectionController@collection_sync')->name('collection-sync');

    Route::post('/save-report', 'AdminController@save_report')->name('save-report');
    Route::get('/reports', 'AdminController@reports_index')->name('reports');
    Route::get('/report-detail/{id}', 'AdminController@report_detail')->name('report-detail');
    Route::get('/report-delete/{id}', 'AdminController@report_delete')->name('report-delete');

    Route::get('/', 'AdminController@dashboard')->name('dashboard');

    Route::get('/webhooks',function (){
        $webhook=Auth::user()->api()->rest('GET','/admin/webhooks.json');
        dd($webhook);
    });
});


