<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 06/01/2019
 * Time: 19:03
 */

namespace App\Services\UserAccount;


use App\User;
use App\UserChat;
use App\UserMessage;

class UserChatsService
{
    public static function getRecentChats($userId){
        // Creating userchat empty array
        $userchats = [];
        $userChats = UserChat::select("*")->where("creator_user_id", $userId)->orWhere("receiver_user_id", $userId)->get();

        //Foreach all userChats of user and pushing them in a array + the sended date and recentchat
        foreach($userChats as $userChat) {
            if($userChat->creator_user_id == $userId) {
                $user = $userChat->receiver;
                $receiver = $userChat->creator;
            } else {
                $user = $userChat->creator;
                $receiver = $userChat->receiver;
            }
            if(isset($user)) {
                 $recentChat = $userChat->getMostRecentMessage($userChat->id);
                 if(isset($recentChat->message) && strlen($recentChat->message) != 0) {
                     array_push($userchats, array('userchat' => $userChat, 'timeSentLast' => date("Y-m-d", strtotime($recentChat->created_at)), "recentChat" => $recentChat, 'user' => $user));
                 }
             }
        }

        // sorting all the userChats on sender date so most recent one is on top
        usort($userchats, function($a, $b) {
            return ($a['timeSentLast'] > $b['timeSentLast']) ? -1 : 1;
        });

        //returning all chats
        return $userchats;
    }

    public static function getUserChatMessages($userChatId, $userId, $admin = 0){
        $userChat = UserChat::select("*")->where("id", $userChatId)->first();
        if($admin == 1){
            $userMessages = UserMessage::select("*")->where("user_chat_id", $userChat->id)->get();
            $admin = true;
        } else {
            $userMessages = UserMessage::select("*")->where("user_chat_id", $userChat->id)->get();
            $admin = false;
        }

        self::seenUserChatMessages($userMessages);
        $user_id = $userId;
        return view("/public/shared/messages/_messagesUserChat", compact("user_id", "userChat", "admin", "userMessages"));
    }

    public static function getUserChatReceiver($receiverUserId){
        $receiver = User::select("*")->where("id", $receiverUserId)->first();
        return view("/public/shared/messages/_receiverUserChat", compact("receiver"));
    }

    private static function seenUserChatMessages($userChatMessages){
        if(count($userChatMessages) > 0) {
            foreach ($userChatMessages as $userMessage) {
                if($userMessage->seen_at == null) {
                    $userMessage->seen_at = date("Y-m-d H:i:s");
                    $userMessage->save();
                }
            }
        }
    }
}