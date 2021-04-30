<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Lineitem;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function dashboard(){

//        $collection = Collection::where('shopify_collection_id', 261771460791)->first();
////        dd($collection->products);
//        foreach($collection->products as $prod){
//            dd($prod->lineitem->order);
//        }

//        $order = Lineitem::where('shopify_lineitem_id', 9632423477431)->first();
////        dd($order);
//        dd($order->order);
        $collection_data = Collection::where('shopify_shop_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(12);
        return view('adminpanel/dashboard', compact('collection_data'));


    }
}
