<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'medium_thumbnail',
        'small_thumbnail',
        'type',
        'source',
        'name',
    ];

    protected $table = 'assets';
    protected $primaryKey = 'id';

    public function assetable()
    {
        return $this->morphTo();
    }
}
