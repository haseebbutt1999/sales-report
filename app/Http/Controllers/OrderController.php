<?php

namespace App\Http\Controllers;

use App\Lineitem;
use App\Order;
use App\Originlocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order_sync()
    {
        $next_page = '';
        $customer = Auth::user();
        $order_count_api = $customer->api()->rest('GET', '/admin/orders/count.json')['body']['count'];

        $count=ceil($order_count_api/250);
        for ($i=1;$i<=$count;$i++)
        {
            $order_api = $customer->api()->rest('GET', '/admin/orders.json',[
                'limit'=>250,
                'page_info'=>$next_page
            ]);

            if(!$order_api['errors'])
            {
                $next_page=$order_api['link']['next'];
                $order_api=json_decode(json_encode($order_api['body']['orders']),FALSE);
//                dd($order_api);
                foreach ($order_api as $order) {
//                    dd($order);
                    $this->CreateUpdateOrder($order, $customer);
                }
            }
        }
        return redirect()->back()->with('success', 'Orders Sync Successfully !');
    }

    public function CreateUpdateOrder($order,$shop)
    {
        $end_lines=[];
        $order=json_decode(json_encode($order),FALSE);
        foreach (json_decode(json_encode($order->line_items),true) as $line_item){
            $variant_id = $line_item['variant_id'];
            $product_id = $line_item['product_id'];
            if($variant_id != null && $product_id!= null){
                $product_api_data = $shop->api()->rest('GET', '/admin/api/2020-10/products/'.$product_id.'.json')['body']['product'];
                $variant_api_data = $shop->api()->rest('GET', '/admin/api/2020-10/variants/'.$variant_id.'.json')['body']['variant'];
                $product_images_array = $product_api_data->images;
                foreach ($product_images_array as $product_image){
                    if( $product_image->id === $variant_api_data->image_id){
                        $line_item['image']=$variant_api_data->src;
                    }elseif (isset($product_image->id)){
                        $line_item['image']=$product_api_data->image->src;
                    }else{
                        $line_item['image']= "null";
                    }
                }
            }
            array_push($end_lines, $line_item);
        }
        $end_lines=json_decode(json_encode($end_lines),FALSE);

        $order_data = Order::where('shopify_order_id', $order->id)->where('shopify_shop_id', auth::user()->id)->first();
        if($order_data == null){
            $order_data = new order();
        }
        $order_data->shopify_shop_id= auth::user()->id ;
        $order_data->email= $order->email ;
        $order_data->shopify_order_id= $order->id;
        $order_data->created_at = Carbon::createFromTimeString($order->created_at)->format('Y-m-d H:i:s');
        $order_data->updated_at = Carbon::createFromTimeString($order->updated_at)->format('Y-m-d H:i:s');
        $order_data->shopify_order_name= $order->name;
        $order_data->total_discounts= $order->total_discounts;
        $order_data->order_status_url= $order->order_status_url;
        $order_data->note= $order->note;
        $order_data->fulfillment_status= $order->fulfillment_status;
        if(isset($order->customer) && $order->customer !== null){
            $order_data->customer= json_encode($order->customer);
        }
        $order_data->line_items= json_encode($end_lines);
        $order_data->payment_gateway_names= json_encode($order->payment_gateway_names);
        $order_data->tax_lines= json_encode($order-> tax_lines);
        $order_data->checkout_id= $order-> checkout_id;
        $order_data->total_price= $order-> total_price;
        $order_data->subtotal_price= $order-> subtotal_price;
        $order_data->total_weight= $order-> total_weight;
        $order_data->total_tax= $order-> total_tax;
        $order_data->currency= $order-> currency;
        $order_data->financial_status= $order-> financial_status;
        $order_data->total_line_items_price= $order-> total_line_items_price;
        $order_data->taxes_included= $order-> taxes_included;
        $order_data->confirmed= $order-> confirmed;
        $order_data->cancel_reason= $order-> cancel_reason;
        $order_data->checkout_token= $order-> checkout_token;
        $order_data->processed_at= Carbon::createFromTimeString($order->processed_at)->format('Y-m-d H:i:s');
        $order_data->order_token= $order->token;
        $order_data->shipping_lines= json_encode($order->shipping_lines);
//        dd($order);
        foreach ($order->line_items as $item) {
//            dd($item);
            if(Lineitem::where('shopify_lineitem_id', $item->id)->where('shopify_shop_id', auth::user()->id)->exists()) {
                $line = Lineitem::where('shopify_lineitem_id', $item->id)->where('shopify_shop_id', auth::user()->id)->first();
            }
            else {
                $line = new Lineitem();
            }
//            dd($item->variant_id);
            $line->shopify_lineitem_id = $item->id;
            $line->shopify_shop_id = auth::user()->id;
            $line->variant_id = $item->variant_id;
            $line->product_id = $item->product_id;
            $line->title = $item->title;
            $line->quantity = $item->quantity;
            $line->sku = $item->sku;
            $line->price = $item->price;
            $line->total_discount = $item->total_discount;
            $line->shopify_order_id = $order->id;
            $line->fulfillable_quantity = $item->fulfillable_quantity;
            $line->properties = json_encode($item->properties);
            if(isset($item->origin_location)){
                $line->origin_location_id = $item->origin_location->id;
//                dd($item->origin_location->name);
                if(Originlocation::where('lineitem_id', $item->id)->where('origin_location_id', $item->origin_location->id)->exists()) {
                    $orign_location = Originlocation::where('lineitem_id', $item->id)->where('origin_location_id', $item->origin_location->id)->first();
                }
                else {
                    $orign_location = new Originlocation();
                }
                $orign_location->lineitem_id = $item->id;
                $orign_location->origin_location_id = $item->origin_location->id;
                $orign_location->name = $item->origin_location->name;
                $orign_location->save();
            }
//            $line->save();
        }
//        $order_data->save();
    }
}
