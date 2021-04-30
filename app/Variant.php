<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    public function Products()
    {
        return $this->belongsTo(Product::class,'shopify_product_id', 'shopify_product_id');
    }
}
