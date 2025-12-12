<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogsLogin extends Model
{
    use HasFactory;

    protected $table = 'log_logins';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'ip',
     ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
