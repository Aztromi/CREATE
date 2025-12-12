<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageContent extends Model
{
    use HasFactory;

    protected $table = 'message_contents';
    protected $primaryKey = 'id';

    protected $fillable = [
        'group_id',
        'sender_id',
        'message',
        'status',
    ];

    public function participants(){
        return $this->hasMany(MessageParticipant::class, 'group_id', 'group_id');
    }

    public function senderUser(){
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function senderProfile()
    {
        return $this->belongsTo(UProfile::class, 'sender_id', 'user_id');
    }

    public function getSenderDispNameAttribute(){
        if ($this->senderProfile) {
            return $this->senderProfile->dispName;
        }
        else if($this->senderUser->isAdminOG()) {
            return "CITEM - " . $this->senderUser->name;
        }
        else {
            return null;
        }
    }

    public function messageLatest(){
        return $this->hasOne(MessageContent::class, 'group_id', 'group_id')->latestOfMany();
    }
}
