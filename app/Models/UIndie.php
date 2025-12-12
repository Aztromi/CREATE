<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UIndie extends Model
{
    // User profile photo and cover photo

    use HasFactory;

    protected $table = 'u_indies';
    protected $primaryKey = 'id';

    protected $fillable = [
        'expertise',
        'type',
        'display_photo',
        'cover_photo',
     ];

    public function profile()
    {
        return $this->belongsTo(UProfile::class, 'u_profile_id');
    }

    public function clients()
    {
        return $this->morphMany(UClient::class, 'ownerable');
    }

    public function expertises()
    {
        return $this->morphMany(UExpertise::class, 'ownerable');
    }
}
