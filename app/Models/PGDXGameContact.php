<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PGDXGameContact extends Model
{
    use HasFactory;

    protected $table = 'pgdx_game_contacts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'score',
        'nickname',
        'firstname',
        'lastname',
        'email',
        'contact_number',
        'status'
    ];

    function game() {
        return $this->belongsTo(PGDXGame::class, 'pgdx_game_id');
    }
}
