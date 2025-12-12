<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\MessageParticipant;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{groupId}', function ($user, $groupId) {
    // Check if the authenticated user is a participant of the given group ID.
    return MessageParticipant::where('participant_id', $user->id)
                             ->where('group_id', $groupId)
                             ->where('status', 1)
                             ->exists();
});