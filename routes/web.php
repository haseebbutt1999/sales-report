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
    Route::get('/location-sync', 'OrderController@sync_locations')->name('location-sync');

    Route::post('/save-report', 'AdminController@save_report')->name('save-report');
    Route::get('/reports', 'AdminController@reports_index')->name('reports');
    Route::get('/report-detail/{id}', 'AdminController@report_detail')->name('report-detail');
    Route::get('/report-delete/{id}', 'AdminController@report_delete')->name('report-delete');

    Route::get('/', 'AdminController@dashboard')->name('dashboard');
    Route::get('settings', 'AdminController@settings')->name('settings');
    Route::post('columns-save', 'AdminController@columns_save')->name('columns-save');

    Route::get('/webhooks',function (){
        $webhook=Auth::user()->api()->rest('GET','/admin/webhooks.json');
        dd($webhook);
    });

    Route::get('location', function (){

//        $shop = Auth::user();
//        $locations = $shop->api()->rest('GET', 'admin/api/2021-04/locations.json')['body']['locations'];
//        dd($locations);

        $customer = Auth::user();

        $order_count_api = $customer->api()->rest('GET', '/admin/orders.json')['body']['orders'];
        dd($order_count_api);

    });

    Route::get('inventory',function(){

        $customer = Auth::user();
        $inventory =  $customer->api()->rest('GET', '/admin/inventory_levels.json',[
            'inventory_item_ids'=>"41888448479392",
//            'location_ids'=>"61573333152",
        ])['body']['container'];
//        $inventory =  $customer->api()->rest('GET', '/admin/locations.json');
        dd($inventory);

    });
});
Route::get('test',function(){

    $customer = Auth::user();
    $inventory =  $customer->api()->rest('GET', '/admin/inventory_items.json',[
        'ids'=>'123'
    ]);
    dd($inventory);
    $c  = \App\Collection::find(17);
//    dd($c);
    $p = $c->Products->where('id',59);
    dd($p);

});


