<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class USocial extends Model
{
    use HasFactory;

    protected $table = 'u_socials';
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
