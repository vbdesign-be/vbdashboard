<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teamleaderConnection extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'accesToken',
        'refreshToken',
        'expiresAt',
        'type',
        'state'
    ];


    

}
