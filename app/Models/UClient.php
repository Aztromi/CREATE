<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UClient extends Model
{
    use HasFactory;

    protected $table = 'u_clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
