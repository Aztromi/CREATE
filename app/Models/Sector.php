<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $table = 'sectors';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'category',
        'list_state',
     ];

    // public function profile()
    // {
    //     return $this->belongsTo(UProfile::class);
    // }
    public function ownerable()  
    {
        return $this->morphTo();
    }
}
