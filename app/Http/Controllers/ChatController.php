<?php

namespace App\Http\Controllers;

use App\Models\ExchangeAds;
use App\Models\ExchangeOffers;
use App\Models\Messages;
use App\Models\Notifications;
use App\Models\OpenedChats;
use App\Models\PendingDeals;
use App\Models\Users;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getChats(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        $chats = OpenedChats::where('user_id', $user->id)->orWhere('owner_id', $user->id)->with('ad')->get();
        foreach ($chats as $chat) {
            $chat->messages = Messages::where('chat_id', $chat->chat_id)->with('user')->orderBy('id', 'DESC')->first();
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
            PendingDeals::create([
                'chat_id' => $chat->chat_id,
                'approved_by_owner' => 0,
                'approved_by_user' => 0
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
        ])->with(['owner', 'user', 'ad', 'messages', 'approved_deal'])->first();
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
        $chat = OpenedChats::where('chat_id', $request->chat_id)->first();
        if ($chat->owner_id == $user->id) {
            $receiver = Users::where('id', $chat->user_id)->first();
        } else {
            $receiver = Users::where('id', $chat->owner_id)->first();
        }
        Notifications::create([
            'user_id' => $receiver->id,
            'message' => 'لديك رسالة جديدة من ' . $receiver->name,
            'read' => false
        ]);
        return Messages::where('id', $message->id)->with(['user'])->first();
    }
    public function approveDeal(Request $request, $id)
    {
        // check if the user is the owner of the ad
        $user = Users::where('token', $request->header('Authorization'))->first();
        $chat = OpenedChats::where('chat_id', $id)->first();
        $check = PendingDeals::where('chat_id', $id)->first();
        if ($chat->owner_id === $user->id) {
            if ($check) {
                $check->approved_by_owner = 1;
                $check->save();
            } else {
                PendingDeals::create([
                    'chat_id' => $id,
                    'approved_by_owner' => 1,
                    'approved_by_user' => 0
                ]);
            }
        } else if ($chat->user_id === $user->id) {
            if ($check) {
                $check->approved_by_user = 1;
                $check->save();
            } else {
                PendingDeals::create([
                    'chat_id' => $id,
                    'approved_by_owner' => 0,
                    'approved_by_user' => 1
                ]);
            }
        }
    }
}
