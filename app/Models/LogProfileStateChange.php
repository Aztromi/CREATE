<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogProfileStateChange extends Model
{
    use HasFactory;

    protected $table = 'log_profile_state_change';
    protected $primaryKey = 'id';

    protected $fillable = [
        'updated_by',
        'new_state',
     ];

    public function ownerable()
    {
        return $this->morphTo();
    }
}
