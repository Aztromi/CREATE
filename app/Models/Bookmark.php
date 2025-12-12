<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    protected $table = 'bookmarks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'bookmarkable_type',
        'bookmarkable_id',
        'user_id',
     ];

     public function user()
     {
        return $this->belongsTo(User::class, 'user_id');
     }

     public function bookmarkable()
     {
         return $this->morphTo();
     }
}
