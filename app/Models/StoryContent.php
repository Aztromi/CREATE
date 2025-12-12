<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryContent extends Model
{
    use HasFactory;

    protected $table = 'story_contents';
    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'value',
     ];

    public function ownerable()
    {
        return $this->morphTo();
    }

}
