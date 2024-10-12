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

    $token = request()->bearerToken();

    if (!$token) {
        return false;
    }

    $credentials = JWTToken::decodeToken($token);
    if ($credentials === 'Unauthorized') {
        return false;
    }

    return $conversation && ($conversation->user_one_id === (int) $credentials->sub || $conversation->user_two_id === (int) $credentials->sub);
});



// Channel for MessageNotification
Broadcast::channel('notifications.{receiverId}', function ($user, $receiverId) {
    $token = request()->bearerToken();

    if (!$token) {
        return false;
    }

    $credentials = JWTToken::decodeToken($token);
    if ($credentials === 'Unauthorized') {
        return false;
    }

    return (int) $credentials->sub === (int) $receiverId;
});



// Presence channel for tracking online users
Broadcast::channel('user-status', function ($user) {
    $token = request()->bearerToken();

    if (!$token) {
        return false;
    }

    $credentials = JWTToken::decodeToken($token);
    if ($credentials === 'Unauthorized') {
        return false;
    }

    return ['id' => $credentials->sub];
});