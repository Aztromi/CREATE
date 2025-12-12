<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCResponse extends Model
{
    use HasFactory;

    protected $table = 'connect_creatives_responses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'custom_id',
        'cc_rqst_id',
        'send_type',
        'status',
    ];

    public function request() {
        return $this->belongsTo(CCRequest::class, 'cc_rqst_id', 'id');
    }

    public function creatives() {
        return $this->hasMany(CCResponseCreative::class, 'cc_rpns_id', 'id');
    }
}
