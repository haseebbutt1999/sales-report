<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    public function variant()
    {
        return $this->belongsTo(Variant::class,'shopify_variant_id', 'shopify_variant_id');
    }
}
