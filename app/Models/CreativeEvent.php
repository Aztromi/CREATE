<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreativeEvent extends Model
{
    use HasFactory;

    protected $table = 'creative_events';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type',
        'date_label',
        'time_label',
        'date_start',
        'date_end',
        'location',
        'registration_link',
        'organizer',
        'fees',
        'description',
        'website',
        'img',
        'status',
     ];
}
