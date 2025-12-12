<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCRequest extends Model
{
    use HasFactory;

    protected $table = 'connect_creatives_requests';
    protected $primaryKey = 'id';

    protected $fillable = [
        'custom_id',
        'requester_id',
        'requester_type',
        'looking_for',
        'budget_range',
        'other_requirements',
        'other_exp',
        'status',
    ];

    public function requester() {
        return $this->morphTo();
    }

    public function goals() {
        return $this->hasMany(CCRequestGoal::class, 'cc_rqst_id', 'id');

    }

    public function professionals() {
        return $this->hasMany(CCRequestProfessional:: class, 'cc_rqst_id', 'id');
    }

    public function responses() {
        return $this->hasMany(CCResponse::class, 'cc_rqst_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, "requester_id");
    }

    public function guest() {
        return $this->belongsTo(Guest::class, "requester_id");
    }

    public function getUserNameAttribute() {
        //
        if($this->requester_type == Guest::class && $this->guest) {
            return $this->guest->name;
        } else if($this->requester_type == User::class && $this->user) {
            if($this->user->isCreative()) {
                return $this->user->profile->dispName;
            } else if($this->user->isMember() || $this->user->isAdmin()) {
                return $this->user->name;
            }
        }

        return "";
    }

    public function getUserTypeAttribute() {
        if($this->requester_type == Guest::class && $this->guest) {
            return "Guest";
        } else if ($this->requester_type == User::class) {
            if($this->user->isAdmin()) {
                return "Admin";
            } else if($this->user->isCreative()) {
                return "Creative";
            } else if($this->user->isMember()) {
                return "Member";
            }
        }
        
        return "";
    }

    public function getStatusTextAttribute() {

        // PHP 7.4 incompatible
        // return match ($this->status) {
        //     0 => "Pending",
        //     1 => "Responded",
        //     2 => "Responded without Recommendation",
        //     default => "-"
        // };

        $statuses = [
            0 => "Pending",
            1 => "Responded",
            2 => "Responded without Recommendation",
        ];

        return $statuses[$this->status] ?? "-";
    }
}
