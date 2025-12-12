<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UJobTitle extends Model
{
    use HasFactory;

    protected $table = 'u_job_titles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
