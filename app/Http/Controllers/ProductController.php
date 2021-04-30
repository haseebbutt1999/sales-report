<?php

namespace App\Http\Controllers;

use App\ErrorLog;
use App\Product;
use App\User;
use App\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function product_sync(){
        $next_page = '';
        $shop = auth::user();
        $product_count_api = $shop->api()->rest('GET', '/admin/products/count.json')['body']['count'];

        $count=ceil($product_count_api/250);
        for ($i=1;$i<=$count;$i++)
        {
            $product_api = $shop->api()->rest('GET', '/admin/products.json',[
                'limit'=>250,
                'page_info'=>$next_page
            ]);

            if(!$product_api['errors'])
            {
                $next_page=$product_api['link']['next'];
                $product_api=json_decode(json_encode($product_api['body']['products']),FALSE);

                foreach ($product_api as $product) {
//                    dd($product);
                    $this->CreateUpdateProduct($product,$shop);
                }
            }
        }
        return redirect()->back()->with('success', 'Products Sync Successfully !');
    }

    public function CreateUpdateProduct($product,$shop){
        $new = new ErrorLog();
        $new->message = json_encode($product->id);
        $new->save();

        $product_save = Product::where('shopify_product_id', $product->id)->where('shopify_shop_id', $shop->id)->first();

        if($product_save == null){
            $product_save = new Product();
        }
        $product_save->shopify_product_id = $product->id;
        $product_save->shopify_shop_id = $shop->id;
        $product_save->body_html = $product->body_html;
        $product_save->title = $product->title;
        $product_save->product_type = $product->product_type;
        $product_save->handle = $product->handle;
        $product_save->published_scope = $product->published_scope;
        $product_save->tags = $product->tags;
        $product_save->vendor = $product->vendor;
        if (isset($product->image->src))
        {
            $product_save->image = $product->image->src;
        }
        $product_save->options = json_encode($product->options);
        foreach ($product->variants as $variant){

            if(Variant::where('shopify_variant_id', $variant->id)->where('shopify_shop_id', $shop->id)->exists()){
                $variant_save = Variant::where('shopify_variant_id', $variant->id)->where('shopify_shop_id', $shop->id)->first();
            }else{
                $variant_save = new Variant();
                $variant_save->old_inventory_quantity = $variant->old_inventory_quantity;
            }
            $variant_save->shopify_product_id = $product->id;
            $variant_save->shopify_variant_id = $variant->id;
            $variant_save->shopify_shop_id = $shop->id;

            foreach($product->images as $product_image_id){
                if($product_image_id->id === $variant->image_id){
                    $variant_save->image = $product_image_id->src;
                }
            }
            $variant_save->title = $variant->title;
            $variant_save->position = $variant->position;
            $variant_save->price = $variant->price;
            $variant_save->sku = $variant->sku;
            $variant_save->inventory_policy = $variant->inventory_policy;
            $variant_save->compare_at_price = $variant->compare_at_price;
            $variant_save->fulfillment_service = $variant->fulfillment_service;
            $variant_save->inventory_management = $variant->inventory_management;
            $variant_save->taxable = $variant->taxable;
            $variant_save->barcode = $variant->barcode;
            $variant_save->weight = $variant->weight;
            $variant_save->weight_unit = $variant->weight_unit;
            $variant_save->admin_graphql_api_id = $variant->admin_graphql_api_id;
            $variant_save->inventory_item_id = $variant->inventory_item_id;
            $variant_save->inventory_quantity = $variant->inventory_quantity;
            $variant_save->requires_shipping = $variant->requires_shipping;
            $variant_save->grams = $variant->grams;
            $variant_save->option1 = $variant->option1;
            $variant_save->option2 = $variant->option2;
            $variant_save->option3 = $variant->option3;
            $variant_save->save();
        }
        $product_save->save();

    }

    public function DeleteProduct($product, $shop){
        $product_save = Product::where('shopify_product_id', $product->id)->first();

        if(isset($product_save)){
            $variant_data = Variant::where('shopify_product_id', $product->id)->get();
            if(isset($variant_data)){
                $variant_data->delete();
            }
            $product_save->delete();
        }

        return true;

    }
}
