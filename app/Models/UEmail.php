<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UEmail extends Model
{
    use HasFactory;

    protected $table = 'u_emails';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'ownerable_type',
        'ownerable_id',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
