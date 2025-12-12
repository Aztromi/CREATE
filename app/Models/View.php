<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

    protected $table = 'views';
    protected $primaryKey = 'id';

    protected $fillable = [
        'viewed_id',
        'viewed_type',
        'user_id',
    ];

    public function viewable()
    {
        return $this->morphTo();
    }


}
