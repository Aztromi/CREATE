<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UAward extends Model
{
    use HasFactory;

    protected $table = 'u_awards';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'source',
        'year',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
