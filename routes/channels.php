<?php

use App\Helpers\JWTToken;
use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


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