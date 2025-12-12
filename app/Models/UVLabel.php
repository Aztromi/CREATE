<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UVLabel extends Model
{
    use HasFactory;

    protected $table = 'u_verification';
    protected $primaryKey = 'id';
    
}
