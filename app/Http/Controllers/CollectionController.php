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
        $shop = Auth::user();
        $smart_collection = $shop->api()->rest('GET', '/admin/api/2020-07/smart_collections.json')['body']['container']['smart_collections'];
        $custom_collection = $shop->api()->rest('GET', '/admin/api/2020-07/custom_collections.json')['body']['container']['custom_collections'];

        $smart_collections = json_decode(json_encode($smart_collection,true));
        $custom_collections = json_decode(json_encode($custom_collection,true));

        $this->CreateUpdateCollection($smart_collections,$custom_collections,$shop);

        return redirect()->back()->with('success', 'Collections Sync Successfully !');
    }

    public function CreateUpdateCollection($smart_collections,$custom_collections,$shop){


        foreach ($smart_collections as $smart_collection){

            $collection = $shop->api()->rest('GET', '/admin/api/2020-07/collections/'.$smart_collection->id.'.json')['body']['container']['collection'];

            $collection = json_decode(json_encode($collection,true));

            $smart_collection_check = Collection::where('shopify_collection_id', $collection->id)->where('shopify_shop_id', $shop->id)->first();

            if($smart_collection_check == null){
                $smart_collection_check = new Collection();
            }
            $smart_collection_check->shopify_collection_id = $collection->id;
            $smart_collection_check->shopify_shop_id = $shop->id;
            $smart_collection_check->title = $collection->title;
            $smart_collection_check->collection_type = $collection->collection_type;
            $smart_collection_check->products_count = $collection->products_count;
            $smart_collection_check->handle = $collection->handle;
//            $smart_collection_check->created_at = Carbon::createFromTimeString($collection->created_at)->format('Y-m-d H:i:s');
            $smart_collection_check->updated_at = Carbon::createFromTimeString($collection->updated_at)->format('Y-m-d H:i:s');
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

            $custom_collection_check = Collection::where('shopify_collection_id', $collection->id)->where('shopify_shop_id', $shop->id)->first();

            if($custom_collection_check == null){
                $custom_collection_check = new Collection();
            }
            $custom_collection_check->shopify_collection_id = $collection->id;
            $custom_collection_check->shopify_shop_id = $shop->id;
            $custom_collection_check->title = $collection->title;
            $custom_collection_check->collection_type = $collection->collection_type;
            $custom_collection_check->products_count = $collection->products_count;
            $custom_collection_check->handle = $collection->handle;
//            $custom_collection_check->created_at = Carbon::createFromTimeString($collection->created_at)->format('Y-m-d H:i:s');
            $custom_collection_check->updated_at = Carbon::createFromTimeString($collection->updated_at)->format('Y-m-d H:i:s');
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
    }

}
