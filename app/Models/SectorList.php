<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectorList extends Model
{
    use HasFactory;

    protected $table = 'sectors_main';
    protected $primaryKey = 'id';
}
