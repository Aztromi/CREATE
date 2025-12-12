<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory;

    protected $table = 'interests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
     ];

    public function profile()
    {
        return $this->belongsTo(UProfile::class);
    }
}
