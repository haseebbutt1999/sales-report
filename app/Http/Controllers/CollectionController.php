<?php

namespace App\Http\Controllers;

use App\Collection;
use App\CollectionProduct;
use App\Customcollection;
use App\Smartcollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CollectionController extends Controller
{
//    sync custom & smart collections
    public function collection_sync(){
        $shop = auth::user();
//        GET /admin/api/2020-07/collections/{collection_id}/products.json
//        $collection = $shop->api()->rest('GET', '/admin/api/2020-07/collections/261771460791/products.json')['body']['container'];
//        dd($collection  );

        $smart_collection = $shop->api()->rest('GET', '/admin/api/2020-07/smart_collections.json')['body']['container']['smart_collections'];
        $custom_collection = $shop->api()->rest('GET', '/admin/api/2020-07/custom_collections.json')['body']['container']['custom_collections'];

//        $smarts_collection=Http::get('https://'.'us.centricwear.com'.'/collect.json')->json();
//        $smarts_collection=Http::get('https://'.'haseeb-butt.myshopify.com'.'/collect.json')->json();
//        $smart_collection = $shop->api()->rest('GET', '/admin/api/2020-10/collections/'.'233437036727'.'/products.json')['body'];
//        dd($collection);


        $smart_collections = json_decode(json_encode($smart_collection,true));
        $custom_collections = json_decode(json_encode($custom_collection,true));



        foreach ($smart_collections as $smart_collection){

            $collection = $shop->api()->rest('GET', '/admin/api/2020-07/collections/'.$smart_collection->id.'.json')['body']['container']['collection'];

            $collection = json_decode(json_encode($collection,true));
//            dd($collection);
            $smart_collection_check = Collection::where('shopify_collection_id', $collection->id)->where('shopify_shop_id', auth::user()->id)->first();
//    dd($smart_collection_check);
            if($smart_collection_check == null){
                $smart_collection_check = new Collection();
            }
            $smart_collection_check->shopify_collection_id = $collection->id;
            $smart_collection_check->shopify_shop_id = auth::user()->id;
            $smart_collection_check->title = $collection->title;
            $smart_collection_check->collection_type = $collection->collection_type;
            $smart_collection_check->products_count = $collection->products_count;
            $smart_collection_check->handle = $collection->handle;
            $smart_collection_check->save();
            $collection_products = $shop->api()->rest('GET', '/admin/api/2020-07/collections/'.$smart_collection->id.'/products.json')['body']['container']['products'];
            foreach ($collection_products as $coll_prod){

                if(CollectionProduct::where('shopify_product_id', $coll_prod['id'])->where('shopify_collection_id', $smart_collection->id)->exists()){
                    $collection_products = CollectionProduct::where('shopify_product_id', $coll_prod['id'])->where('shopify_collection_id', $smart_collection->id)->first();
                }else{
                    $collection_products = new CollectionProduct();
                }
                $collection_products->shopify_product_id =  $coll_prod['id'];
                $collection_products->shopify_collection_id =  $smart_collection->id;
                $collection_products->save();
            }

        }

        foreach ($custom_collections as $custom_collection){

            $collection = $shop->api()->rest('GET', '/admin/api/2020-07/collections/'.$custom_collection->id.'.json')['body']['container']['collection'];

            $collection = json_decode(json_encode($collection,true));
//            dd($collection);
            $custom_collection_check = Collection::where('shopify_collection_id', $collection->id)->where('shopify_shop_id', auth::user()->id)->first();
//    dd($smart_collection_check);
            if($custom_collection_check == null){
                $custom_collection_check = new Collection();
            }
            $custom_collection_check->shopify_collection_id = $collection->id;
            $custom_collection_check->shopify_shop_id = auth::user()->id;
            $custom_collection_check->title = $collection->title;
            $custom_collection_check->collection_type = $collection->collection_type;
            $custom_collection_check->products_count = $collection->products_count;
            $custom_collection_check->handle = $collection->handle;
            $custom_collection_check->save();
            $collection_products = $shop->api()->rest('GET', '/admin/api/2020-07/collections/'.$custom_collection->id.'/products.json')['body']['container']['products'];
            foreach ($collection_products as $coll_prod){

                if(CollectionProduct::where('shopify_product_id', $coll_prod['id'])->where('shopify_collection_id', $custom_collection->id)->exists()){
                    $collection_products = CollectionProduct::where('shopify_product_id', $coll_prod['id'])->where('shopify_collection_id', $custom_collection->id)->first();
                }else{
                    $collection_products = new CollectionProduct();
                }
                $collection_products->shopify_product_id =  $coll_prod['id'];
                $collection_products->shopify_collection_id =  $custom_collection->id;
                $collection_products->save();
            }

        }

        return redirect()->back()->with('success', 'Collections Sync Successfully !');
    }

}
