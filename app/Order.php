<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function lineitems()
    {
        return $this->hasMany(Lineitem::class, 'shopify_order_id', 'shopify_order_id');
    }
}
