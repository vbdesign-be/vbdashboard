<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOrder extends Model
{
    use HasFactory;

    public function order(){
        return $this->belongsTo(\App\Models\Order::class);
    }
}
