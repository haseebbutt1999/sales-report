<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryLocationQuantity extends Model
{
    public function Variants(){
        return $this->hasMany(Variant::class, 'inventory_item_id', 'inventory_item_id');
    }
}
