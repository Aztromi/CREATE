<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UAddress extends Model
{
    use HasFactory;

    protected $table = 'u_addresses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'country',
        'region',
        'province',
        'municipality',
        'street',
        'block_lot',
        'postal_code',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
