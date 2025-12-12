<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    // use HasFactory;

    protected $table = 'stories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'cover_image',
        'link',
        'category',
        'published_at',
        'published_status',
        'ownerable_type',
        'ownerable_id',
     ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerable_id');
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'ownerable');
    }

    public function latestSlug()
    {
        return $this->morphOne(Slug::class, 'ownerable')->latestOfMany();
    }

    public function storyContents()
    {
        return $this->morphMany(StoryContent::class, 'ownerable');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function scopeArticles($query)
    {
        return $query->where('category', 'article');
    }

    public function scopeVideos($query)
    {
        return $query->where('category', 'video');
    }

    public function views()
     {
         return $this->morphMany(View::class, 'viewable');
     }

     public function bookmarks()
     {
         return $this->morphMany(Bookmark::class, 'bookmarkable');
     }
}
