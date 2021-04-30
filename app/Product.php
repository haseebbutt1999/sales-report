<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function Collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_products','shopify_product_id','shopify_collection_id','shopify_product_id','shopify_collection_id','shopify_product_id','shopify_collection_id');
    }

    public function lineitem()
    {
        return $this->belongsTo('App\Lineitem', 'shopify_product_id', 'product_id');
    }
    public function Variants(){
        return $this->hasMany(Variant::class, 'shopify_product_id', 'shopify_product_id');
    }
}
