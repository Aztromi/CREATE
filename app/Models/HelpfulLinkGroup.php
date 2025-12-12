<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpfulLinkGroup extends Model
{
    use HasFactory;

    protected $table = 'helpful_links_groups';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'order',
        'status',
    ];

    public function helpfulLinks() {
        return $this->hasMany(HelpfulLink::class, 'group_id', 'id');
    }
}
