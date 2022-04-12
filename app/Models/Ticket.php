<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    // protected $with = ["reaction"];
    // public function reaction(){
    //     return $this->hasMany(\App\Models\Reaction::class);
    // }
}
