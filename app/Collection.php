<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public function Products()
    {
        return $this->belongsToMany(Product::class,CollectionProduct::class ,'shopify_collection_id','shopify_product_id','shopify_collection_id','shopify_product_id');
    }
}
