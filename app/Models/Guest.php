<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $table = 'guests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'company_name',
        'company_email',
        'country',
        'company_address',
        'status',
    ];

    public function cc_requests() {
        return $this->morphMany(CCRequest::class, 'requester');
    }
}
