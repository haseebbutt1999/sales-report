<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    public function Products()
    {
        return $this->belongsTo(Product::class,'shopify_product_id', 'shopify_product_id');
    }

    public function inventory_levels(){
        return $this->hasMany(Inventorylevel::class, 'inventory_item_id', 'inventory_item_id');
    }
    public function quantities(){
        return $this->hasMany(Quantity::class, 'shopify_variant_id', 'shopify_variant_id');
    }
}
