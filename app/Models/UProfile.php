<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\User;

class UProfile extends Model
{
    use HasFactory;

    protected $table = 'u_profiles';
    protected $primaryKey = 'id';

    protected $appends = ['disp_name'];

    protected $fillable = [
      'user_id',
      'first_name',
      'last_name',
      'about',
      'gender',
      'other_name',
      'display_name',
      'company_name',
      'is_new',
      'has_profile_reminder',
      'upload_drive_link',
      'hide_email',
      'hide_contact',
      'hide_address',
   ];

    public function user()
    {
        // return $this->belongsTo(User::class, 'user_id', 'id');
        return $this->belongsTo(User::class);
    }

    public function slugs()
    {
         return $this->morphMany(Slug::class, 'ownerable');
    }

    public function latestSlug()
    {
        return $this->morphOne(Slug::class, 'ownerable')->latestOfMany();
    }

    public function uindie()
    {
        // User profile photo and cover photo
        return $this->hasOne(UIndie::class, 'u_profile_id');
    }

    public function sectors()
    {
      //   return $this->hasMany(Sector::class);
      return $this->morphMany(Sector::class, 'ownerable');
    }

    public function interests()
    {
        return $this->hasMany(Interest::class);
    }

    public function getFullNameAttribute()
     {
          return $this->first_name . ' ' . $this->last_name;
     }

     public function getDispNameAttribute()
     {
          if ($this->display_name == 'fullname') 
          {
            return $this->getFullNameAttribute();
          } 
          elseif ($this->display_name == 'company_name') 
          {
            return $this->company_name;
          } 
          elseif ($this->display_name == 'other_name') 
          {
            return $this->other_name;
          } 
          else 
          {
            return $this->getFullNameAttribute();
          }
     }

     public function address()
     {
        return $this->morphMany(UAddress::class, 'ownerable');
     }

     public function addressLatest()
     {
        return $this->morphOne(UAddress::class, 'ownerable')->latestOfMany();
     }

     public function awards()
     {
        return $this->morphMany(UAward::class, 'ownerable');
     }

     public function educations()
     {
        return $this->morphMany(UEducation::class, 'ownerable');
     }

     public function emails()
     {
      //   return $this->morphMany(UEmail::class, 'ownerable');
         return $this->morphMany(UEmail::class, 'ownerable');
     }

     public function jobTitles()
     {
        return $this->morphMany(UJobTitle::class, 'ownerable');
     }

     public function jobTitleFirst()
     {
        return $this->morphOne(UJobTitle::class, 'ownerable')->oldestOfMany();
     }

     public function jobTitleLatest()
     {
        return $this->morphOne(UJobTitle::class, 'ownerable')->latestOfMany();
     }

     public function numContactTypes()
     {
        return $this->morphMany(UNumContactType::class, 'ownerable');
     }

     public function numContacts()
     {
        return $this->morphMany(UNumContact::class, 'ownerable');
     }

     public function socials()
     {
        return $this->morphMany(USocial::class, 'ownerable');
     }

     public function websites()
     {
        return $this->morphMany(UWebsite::class, 'ownerable');
     }

     public function workExperiences()
     {
        return $this->morphMany(UWorkExp::class, 'ownerable');
     }

     public function views()
     {
         return $this->morphMany(View::class, 'viewable');
     }

     public function bookmarks()
     {
         return $this->morphMany(Bookmark::class, 'bookmarkable');
     }

     public function company()
     {
        return $this->morphOne(UCompany::class, 'ownerable')->latestOfMany();;
     }

     public function attendance()
     {
        return $this->morphMany(UAttendance::class, 'ownerable');
     }

     public function attendanceLatest()
     {
        return $this->morphOne(UAttendance::class, 'ownerable')->latestOfMany()->where('fair_code', config('app.event_faircode'));
     }

     public function logsProfileStateChange()
     {
        return $this->morphMany(LogsProfileStateChange::class, 'ownerable');
     }
}
