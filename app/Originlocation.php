<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Originlocation extends Model
{
    public function line_item()
    {
        return $this->belongsTo(Lineitem::class, 'lineitem_id');
    }
}
