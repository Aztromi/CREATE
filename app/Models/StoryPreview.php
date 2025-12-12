<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryPreview extends Model
{
    use HasFactory;

    protected $table = 'story_previews';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerable_id');
    }

    public function storyContents()
    {
        return $this->morphMany(StoryContent::class, 'ownerable');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
