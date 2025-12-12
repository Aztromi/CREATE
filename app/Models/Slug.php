<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasFactory;

    protected $table = 'slugs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
     ];

    public function ownerable()
    {
        return $this->morphTo();
    }

}
