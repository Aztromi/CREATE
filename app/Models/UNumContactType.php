<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNumContactType extends Model
{
    use HasFactory;

    protected $table = 'u_num_contact_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'type',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }

}
