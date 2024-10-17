<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\MessageNotification;
use App\Events\MessageSent;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Summary of createConversation
     * @param \Illuminate\Http\Request $request
     * - user_id: int (Target user ID)
     * - auth: int (Authenticated user ID) - This is automatically added by the @file \JwtMiddleware.php
     * @return \App\Helpers\ResponseHelper::sendSuccess | ResponseHelper::sendError
     */
    public function createConversation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Get the authenticated user ID
        $auth_id = auth('api')->user()->id;

        $conversation = Conversation::where(function ($query) use ($auth_id, $request) {
            $query->where('user_one_id', $auth_id)
                ->where('user_two_id', $request->user_id);
        })->orWhere(function ($query) use ($auth_id, $request) {
            $query->where('user_one_id', $request->user_id)
                ->where('user_two_id', $auth_id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $auth_id,
                'user_two_id' => $request->user_id,
            ]);
        }

        return ResponseHelper::sendSuccess('Conversation created successfully', $conversation, 201);
    }


    /**
     * Summary of sendMessage
     * @param \Illuminate\Http\Request $request
     * @param mixed $conversationId
     * - message: string
     * - auth: int (Authenticated user ID) - This is automatically added by the @file \JwtMiddleware.php
     * @return \App\Helpers\ResponseHelper::sendSuccess | ResponseHelper::sendError
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Get the authenticated user ID
        $auth_id = auth('api')->user()->id;

        $conversation = Conversation::findOrFail($conversationId);

        // Ensure the authenticated user is part of the conversation
        if ($conversation->user_one_id !== $auth_id && $conversation->user_two_id !== $auth_id) {
            return ResponseHelper::sendError('Unauthorized', null, 403);
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $auth_id,
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();


        // Dispatch the MessageNotification event for the other user
        $receiverId = $conversation->user_one_id === $auth_id ? $conversation->user_two_id : $conversation->user_one_id;
        broadcast(new MessageNotification($message, $receiverId))->toOthers();

        return ResponseHelper::sendSuccess('Conversation created successfully', $message, 201);
    }

    /**
     * Summary of getMessages
     * @param \Illuminate\Http\Request $request
     * @param mixed $conversationId
     * - auth: int (Authenticated user ID) - This is automatically added by the @file \JwtMiddleware.php
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getMessages(Request $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        // Get the authenticated user ID
        $auth_id = auth('api')->user()->id;

        // Ensure the authenticated user is part of the conversation
        if ($conversation->user_one_id !== $auth_id && $conversation->user_two_id !== $auth_id) {
            return ResponseHelper::sendError('Unauthorized', null, 403);
        }

        $messages = $conversation->messages()->with('sender')->get();

        return ResponseHelper::sendSuccess('Conversation created successfully', $messages, 201);
    }
}