<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UNumContact extends Model
{
    use HasFactory;

    protected $table = 'u_num_contacts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'number',
        'country_code',
        'type',
        
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
