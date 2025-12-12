<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subheader',
        'date',
        'featured',
        'published',
        'content',
        'banner_caption',
        'author',
        'industry',
    ];

    public function asset()
    {
        return $this->morphOne(Asset::class, 'assetable');
    }

    public function slugs()
    {
        return $this->morphMany(Slug::class, 'ownerable');
    }

    public function latestSlug()
    {
        return $this->morphOne(Slug::class, 'ownerable')->latestOfMany();
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
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


