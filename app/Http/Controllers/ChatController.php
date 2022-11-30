<?php

namespace App\Http\Controllers;

use App\Models\ExchangeAds;
use App\Models\ExchangeOffers;
use App\Models\Messages;
use App\Models\OpenedChats;
use App\Models\Users;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChats(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $chats = OpenedChats::where('user_id', $user->id)->orWhere('owner_id', $user->id)->get();
        foreach ($chats as $chat) {
            $chat->messages = Messages::where('chat_id', $chat->chat_id)->with(['user', 'ad'])->orderBy('id', 'DESC')->first();
        }
        return $chats;
    }
    public function newChat(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $ifOpened = OpenedChats::where([
            ['owner_id', $user->id],
            ['user_id', $request->user_id],
            ['ad_id', $request->ad_id],
        ])->first();
        if ($ifOpened) {
            return response()->json([
                'status' => 'success',
                'chat_id' => $ifOpened->chat_id
            ]);
        } else {
            $chat = OpenedChats::create([
                'owner_id' => $user->id,
                'user_id' => $request->user_id,
                'ad_id' => $request->ad_id,
                'chat_id' => uniqid()
            ]);
            return response()->json([
                'status' => 'success',
                'chat_id' => $chat->chat_id
            ]);
        }
    }
    public function getChat(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $chat = OpenedChats::where([
            ['chat_id', $request->chat_id],
            ['owner_id', $user->id]
        ])->orWhere([
            ['chat_id', $request->chat_id],
            ['user_id', $user->id]
        ])->with(['owner', 'user', 'ad', 'messages'])->first();
        if ($chat == null) {
            return response()->json([
                'alert' => 'Chat not found'
            ], 404);
        }
        return $chat;
    }
    public function sendMessage(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $message = Messages::create([
            'chat_id' => $request->chat_id,
            'user_id' => $user->id,
            'message' => $request->message
        ]);
        return Messages::where('id', $message->id)->with(['user'])->first();
    }
}
