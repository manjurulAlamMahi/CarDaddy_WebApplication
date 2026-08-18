<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Traits\apiresponse;
use DB;
use Illuminate\Http\Request;
use App\Events\ChatMessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    use apiresponse;

    public function sendMessage(Request $request)
    {
        $receiverId = $request->receiver_id;
        // Generate a unique conversation id based on the two user ids
        $conversationId = implode('-', [min(Auth::user()->id, $receiverId), max(Auth::user()->id, $receiverId)]);

        $chat = Chat::create([
            'sender_id'       => Auth::user()->id,
            'receiver_id'     => $receiverId,
            'message'         => $request->message,
            'conversation_id' => $conversationId,
        ]);

        // Broadcast the message
        broadcast(new ChatMessageSent($chat))->toOthers();

        return $this->success($chat, 'Message sent successfully', 200);
    }

    public function fetchMessages(Request $request)
    {
        $receiverId = $request->request_id;
        $conversationId = implode('-', [min(Auth::user()->id, $receiverId), max(Auth::user()->id, $receiverId)]);

        $messages = Chat::where('conversation_id', $conversationId)
            ->orderBy('created_at', 'asc')
            ->get();

        return $this->success($messages, 'Data Fetch Success', 200);
    }
}
