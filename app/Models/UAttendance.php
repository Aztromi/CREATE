<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UAttendance extends Model
{
    use HasFactory;

    protected $table = 'u_attendance';
    protected $primaryKey = 'id';

    // status: 0=incomplete, 1=approved, 2=pending, 5=denied, 6=deleted
    protected $fillable = [
        'fair_code',
        'status',
    ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
