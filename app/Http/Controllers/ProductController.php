<?php

namespace App\Http\Controllers;

use App\ErrorLog;
use App\Inventorylevel;
use App\InventorylevelVariant;
use App\InventoryLocationQuantity;
use App\Product;
use App\Quantity;
use App\User;
use App\Variant;
use Carbon\Carbon;
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
        return redirect()->route('dashboard')->with('success', 'Products Sync Successfully !');
    }

    public function CreateUpdateProduct($product,$shop){

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
            }
            if($variant_save->old_inventory_quantity <= $variant->old_inventory_quantity){
                $variant_save->old_inventory_quantity = $variant->old_inventory_quantity;
            }

            // add quantity to new table start
//            $quantity = Quantity::where('shopify_shop_id',$shop->id)->where('shopify_variant_id',$variant->id)->first();
//            if(Variant::where('shopify_variant_id', $variant->id)->where('shopify_shop_id', $shop->id)->exists()){
//
//            }
            if(!isset($variant_save->inventory_quantity) || $variant_save->inventory_quantity != $variant->inventory_quantity){
                $quantity = new Quantity();
                $quantity->quantity = $variant->inventory_quantity;
                $quantity->shopify_variant_id = $variant->id;
                $quantity->shopify_shop_id = $shop->id;
                $quantity->created_at = Carbon::createFromTimeString($variant->updated_at)->format('Y-m-d H:i:s');
                $quantity->save();


            }

// add quantity to new table end

            $variant_save->shopify_product_id = $product->id;
            $variant_save->shopify_variant_id = $variant->id;
            $variant_save->shopify_shop_id = $shop->id;
//            $inventory_location_quantity =   InventoryLocationQuantity::where('inventory_item_id',$variant->inventory_item_id)->first();
//            if($inventory_location_quantity == null){
                $inventory =  $shop->api()->rest('GET', '/admin/inventory_levels.json',[
                    'inventory_item_ids'=>$variant->inventory_item_id,
//            'location_ids'=>"61573333152",
                ])['body']['container']['inventory_levels'];

                if( isset($inventory)){
                    foreach ($inventory as $inv){
                    $updated_date = Carbon::createFromTimeString($inv['updated_at'])->format('Y-m-d H:i:s');
                    $inv_save =   InventoryLocationQuantity::where('inventory_item_id',$variant->inventory_item_id)->where('location_id',$inv['location_id'])->where('created_at',$updated_date)->first();
                    dd($inv_save);
                    if($inv_save == null){
                        $inv_save  = new InventoryLocationQuantity();
                    }
                    $inv_save->inventory_item_id = $variant->inventory_item_id;
                    $inv_save->location_id = $inv['location_id'];
                    $inv_save->available = $inv['available'];
                    $inv_save->created_at = Carbon::createFromTimeString($inv['updated_at'])->format('Y-m-d H:i:s');
                    $inv_save->save();
                }
//                }
            }

//            foreach($product->images as $product_image_id){
//                if($product_image_id->id === $variant->image_id){
//                    $variant_save->image = $product_image_id->src;
//                }
//            }
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
            $variant_save->created_at = Carbon::createFromTimeString($variant->created_at)->format('Y-m-d H:i:s');
            $variant_save->updated_at = Carbon::createFromTimeString($variant->updated_at)->format('Y-m-d H:i:s');
            $variant_save->save();


        }
        $product_save->created_at = Carbon::createFromTimeString($product->created_at)->format('Y-m-d H:i:s');
        $product_save->updated_at = Carbon::createFromTimeString($product->updated_at)->format('Y-m-d H:i:s');
        $product_save->save();

    }

    public function DeleteProduct($product, $shop){
        $product_save = Product::where(['shopify_product_id'=> $product->id,'shopify_shop_id'=>$shop->id])->first();
        if(isset($product_save)){
            $variant_data = Variant::where(['shopify_product_id'=> $product->id,'shopify_shop_id'=>$shop->id])->delete();

            $product_save->delete();
        }

        return true;

    }

    public function CreateUpdateInventorylevel($inventorylevelData,$shop){
        try {

            $variant_inventory_level_data = Variant::where('inventory_item_id', $inventorylevelData->inventory_item_id)->where('shopify_shop_id', $shop->id)->first();
            if($variant_inventory_level_data != null){
//                $inventory_level_data = Inventorylevel::where('inventory_item_id', $inventorylevelData->inventory_item_id)->first();
//
//                if($inventory_level_data == null){
                    $inventory_level_data = new Inventorylevel();
                    $inventory_level_data->old_available = $inventorylevelData->available;
                    $inventory_level_data->available = $inventorylevelData->available;

//                }
//                if($inventory_level_data->old_available != null && $inventory_level_data->old_available > $inventorylevelData->available ){
//                    $inventory_level_data->available = $inventorylevelData->available;
//                    $inventory_level_data->old_available = $inventorylevelData->available;
//                }
                $inventory_level_data->location_id = $inventorylevelData->location_id;
                $inventory_level_data->inventory_item_id = $inventorylevelData->inventory_item_id;

                $inventory_level_data->created_at = Carbon::createFromTimeString($inventorylevelData->updated_at)->format('Y-m-d H:i:s');
                $inventory_level_data->save();
                $inventory_variant_quantity = Variant::where('inventory_item_id', $inventorylevelData->inventory_item_id)->where('shopify_shop_id', $shop->id)->first();
                if($inventory_variant_quantity != null){
                    $inventory_variant = new InventorylevelVariant();
                    $inventory_variant->inventory_id = $inventorylevelData->inventory_item_id;
                    $inventory_variant->variant_id = $inventory_variant_quantity->shopify_variant_id;
                    $inventory_variant->save();
                }
            }


        } catch (\Exception $exception){
            $new = new ErrorLog();
            $new->message = "inventory level update error ".$exception->getMessage();
            $new->save();
        }
    }
}
