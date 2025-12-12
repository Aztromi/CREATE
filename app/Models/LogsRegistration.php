<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsRegistration extends Model
{
    use HasFactory;

    protected $table = 'log_registrations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'step',
        'user_id',
        'ip',
     ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
