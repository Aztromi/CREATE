<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageParticipant extends Model
{
    use HasFactory;

    protected $table = 'message_participants';
    protected $primaryKey = 'id';

    protected $fillable = [
        'group_id',
        'participant_id',
        'notify',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'participant_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(UProfile::class, 'participant_id', 'user_id');
    }

    public function getParticipantDispNameAttribute(){
        if ($this->profile) {
            return $this->profile->dispName;
        }
        else if($this->user->isAdminOG()) {
            return "CITEM - " . $this->user->name;
        }
        else {
            return null;
        }
    }
}
