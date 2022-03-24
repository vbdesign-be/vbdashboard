<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with = ["emailorder"];
    public function emailorder(){
        return $this->hasMany(\App\Models\EmailOrder::class);
    }
}
