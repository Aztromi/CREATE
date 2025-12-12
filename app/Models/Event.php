<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

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

    public function eventspeakers()
    {
        return $this->hasMany(EventSpeaker::class);
    }
}
