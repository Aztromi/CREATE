<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UExpertise extends Model
{
    use HasFactory;

    protected $table = 'u_expertises';
    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'category',
        'type',
        'list_state',
     ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
