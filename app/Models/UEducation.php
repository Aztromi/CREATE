<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UEducation extends Model
{
    use HasFactory;

    protected $table = 'u_educations';
    protected $primaryKey = 'id';

    public function ownerable()
    {
        return $this->morphTo();
    }
}
