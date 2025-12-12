<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCRequestProfessional extends Model
{
    use HasFactory;

    protected $table = 'connect_creatives_requests_professionals';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cc_rqst_id',
        'value',
    ];

    public function request() {
        return $this->belongsTo(CCRequest::class, 'cc_rqst_id', 'id');
    }
}
