<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UWorkExp extends Model
{
    use HasFactory;

    protected $table = 'u_work_exps';
    protected $primaryKey = 'id';

    public function ownerable()
    {
        return $this->morphTo();
    }
}
