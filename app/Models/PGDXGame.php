<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PGDXGame extends Model
{
    use HasFactory;

    protected $table = 'pgdx_games';
    protected $primaryKey = 'id';

    protected $fillable = [
        'play_id',
        'game'
    ];

    function contact() {
        return $this->hasOne(PGDXGameContact::class, 'pgdx_game_id');
    }
}
