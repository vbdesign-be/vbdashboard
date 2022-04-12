<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;
    protected $with = ["user"];

    // public function ticket(){
    //     return $this->belongsTo(\App\Models\Ticket::class);
    // }

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
}
