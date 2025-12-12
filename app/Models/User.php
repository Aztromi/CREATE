<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'verified',
        'approved',
        'status',
        'type',
        'requests',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function profile() {
        return $this->hasOne(UProfile::class);
    }

    // public function bookmarks()
    // {
    //     return $this->hasMany(Bookmark::class, 'user_id');
    // }

    public function stories() {
        return $this->hasMany(Story::class, 'ownerable_id');
    }

    public function storyPreviews() {
        return $this->hasMany(StoryPreview::class, 'ownerable_id');
    }

    public function homeStoryLatest() {
        // return $this->hasOne(Story::class, 'ownerable_id')->latestOfMany();
        return $this->hasOne(Story::class, 'ownerable_id')->latestOfMany()->where('published_status', 1);
    }

    public function vLabel() { //verified column to u_verification.value .  For labels
        return $this->hasOne(UVLabel::class, 'value', 'verified');
    }

    public function isUser() {
        if($this->type == 'normal' && $this->user_role_id == null && ($this->verified = -1 || $this->verified = 0 || $this->verified = 1))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isMember() {
        if($this->type == 'normal' && $this->user_role_id == null && $this->verified == -1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isCreative() {
        return $this->type == 'normal' && $this->user_role_id == null && in_array($this->verified, [0, 1]);
    }

    public function isAdmin() {
        if($this->status == "active" && $this->user_role_id == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isAdminOG() {
        if($this->status == "active" && $this->user_role_id == 1 && ($this->type == "super" || $this->type == "og"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function scopeApprovedVerified($query) {
        // Local Scope for all Approved, Verified or Unverified Users
        // call approvedVerifiedUnverified
        return $query->where([
                ['type', 'normal'],
                ['user_role_id', null],
                ['approved', 1],
                ['verified', 1]
        ]);
    }


    public function scopeApprovedVerifiedUnverified($query) {
        // Local Scope for all Approved, Verified or Unverified Users
        // call approvedVerifiedUnverified
        return $query->where([
                ['type', 'normal'],
                ['approved', 1],
                ['user_role_id', null]
            ])
            ->whereIn('verified', [0, 1]);
    }

    public function scopeAllUsers($query) {
        // Local Scope for all Approved, Verified or Unverified Users
        // call approvedVerifiedUnverified
        return $query->where('type', 'normal')
            ->where('user_role_id', null)
            // ->where(function($query){
            //     $query->where('verified', 1)->orWhere('verified', 0)->orWhere('verified', -1);
            ->whereIn('verified', [-1, 0, 1]);
    }

    public function scopeAllAdmin($query) {
        return $query->where('user_role_id', 1)
            ->whereIn('type', ['super', 'og', 'bdu', 'editor']);
    }

    // public function allStoryCount()
    // {
    //     return $this->stories->count();
    // }

    public function allStoryBookmarksCount() {
        return $this->stories->sum(function ($story) {
            return $story->bookmarks->count();
        });
    }

    // public function allProfileLikesCount()
    // {
    //     return $this->profile->bookmarksCount();
    // }

    // public function allProfileViewsCount()
    // {
    //     return $this->profile->bookmarksCount();
    // }

    public function loginLogs() {
        return $this->hasMany(LogsLogin::class, 'user_id');
    }

    public function registrationLogs() {
        return $this->hasMany(LogsRegistration::class, 'user_id');
    }

    public function uploadedRequirements() {
        return $this->hasMany(UploadedRequirement::class, 'user_id');
    }

    public function messageParticipations() {
        return $this->hasMany(MessageParticipant::class, 'participant_id');
    }

    public function cc_requests() {
        return $this->morphMany(CCRequest::class, 'requester');
    }
    
}
