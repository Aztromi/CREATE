<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'type'
    ];

    protected $table = 'tags';
    protected $primaryKey = 'id';

    public function taggable()
    {
        return $this->morphTo();
    }
}
