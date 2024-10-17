<?php

use App\Helpers\JWTToken;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Channel for Conversation
Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = Conversation::where('id', $conversationId)->first();
    return $conversation && ($conversation->user_one_id === (int) $user->id || $conversation->user_two_id === (int) $user->id);
});



// Channel for MessageNotification
Broadcast::channel('notifications.{receiverId}', function ($user, $receiverId) {
    return (int) $user->id === (int) $receiverId;
});



// Presence channel for tracking online users
Broadcast::channel('user-status', function ($user) {
    return $user;
});