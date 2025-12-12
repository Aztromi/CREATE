<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpfulLink extends Model
{
    use HasFactory;

    protected $table = 'helpful_links';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'img',
        'group_id',
        'website',
        'status',
    ];

    public function helpfulLinkGroup() {
        return $this->belongsTo(HelpfulLinkGroup::class, 'group_id', 'id');
    }
}
