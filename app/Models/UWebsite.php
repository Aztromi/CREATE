<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UWebsite extends Model
{
    use HasFactory;

    protected $table = 'u_websites';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
