<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function report_items()
    {
        return $this->hasMany(Reportitem::class);
    }
}
