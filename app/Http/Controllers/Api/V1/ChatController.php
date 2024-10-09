<?php

namespace App\Http\Controllers\Api\V1;

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

        $conversation = Conversation::create([
            'user_one_id' => $request->auth,
            'user_two_id' => $request->user_id,
        ]);

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

        $conversation = Conversation::findOrFail($conversationId);

        // Ensure the authenticated user is part of the conversation
        if ($conversation->user_one_id !== $request->auth || $conversation->user_two_id !== $request->auth) {
            return ResponseHelper::sendError('Unauthorized', null, 403);
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'sender_id' => $request->auth,
            'message' => $request->message,
        ]);

        return ResponseHelper::sendSuccess('Conversation created successfully', [
            'message' => $message
        ], 201);
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

        // Ensure the authenticated user is part of the conversation
        if ($conversation->user_one_id !== $request->auth || $conversation->user_two_id !== $request->auth) {
            return ResponseHelper::sendError('Unauthorized', null, 403);
        }

        $messages = $conversation->messages()->with('sender')->get();

        return ResponseHelper::sendSuccess('Conversation created successfully', [
            'messages' => $messages
        ], 201);
    }

    /**
     * Summary of getUsersList
     * @param \Illuminate\Http\Request $request
     * - auth: int (Authenticated user ID) - This is automatically added by the @file \JwtMiddleware.php
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUsersList(Request $request)
    {
        $users = User::whereNot('id', $request->auth)->get();
        return ResponseHelper::sendSuccess('Users fetched successfully', [
            'users' => $users
        ], 200);
    }
}