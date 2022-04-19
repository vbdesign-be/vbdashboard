<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $with = ["attachmentsTicket", "reactions", "user", "cc", "notitie"];
    public function attachmentsTicket(){
        return $this->hasMany(\App\Models\AttachmentTicket::class);
    }

    public function reactions(){
        return $this->hasMany(\App\Models\Reaction::class);
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function cc(){
        return $this->hasMany(\App\Models\Cc::class);
    }

    public function notitie(){
        return $this->hasOne(\App\Models\Notitie::class);
    }
    
}
