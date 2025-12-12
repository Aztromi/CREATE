<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCResponseCreative extends Model
{
    use HasFactory;

    protected $table = 'connect_creatives_responses_creatives';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cc_rpns_id',
        'value',
    ];

    public function response() {
        return $this->belongsTo(CCResponse::class, 'cc_rpns_id', 'id');
    }

    public function profile() {
        return $this->belongsTo(UProfile::class,'value','id');
    }


}
