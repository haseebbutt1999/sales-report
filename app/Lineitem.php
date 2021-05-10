<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineitem extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product', 'shopify_product_id','product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'shopify_order_id', 'shopify_order_id');
    }

    public function origin_location()
    {
        return $this->hasOne(Originlocation::class, 'lineitem_id', 'shopify_lineitem_id');
    }
}
