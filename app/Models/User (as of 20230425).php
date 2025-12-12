<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $hidden = [
		'password', 'remember_token',
	];

    public function profile()
    {
        return $this->hasOne(UProfile::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'ownerable_id');
    }

    public function storyPreviews()
    {
        return $this->hasMany(StoryPreview::class, 'ownerable_id');
    }

    public function homeStoryLatest()
    {
        return $this->hasOne(Story::class, 'ownerable_id')->latestOfMany();
    }

}
