<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $with = ["attachmentsTicket", "reactions"];
    public function attachmentsTicket(){
        return $this->hasMany(\App\Models\AttachmentTicket::class);
    }

    public function reactions(){
        return $this->hasMany(\App\Models\Reaction::class);
    }
}
