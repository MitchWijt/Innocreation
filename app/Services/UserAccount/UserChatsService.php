<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 06/01/2019
 * Time: 19:03
 */

namespace App\Services\UserAccount;


use App\Emoji;
use App\Services\emptyRecentChat;
use App\Services\TimeSent;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Support\Facades\Session;
use App\Services\InnoClass;

class UserChatsService
{

    public function userAccountChatsIndex(){
        $pageType = "noFooter";
        $user_id = Session::get("user_id");
        $innocreationChat = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", 1)->first();
        $user = User::select("*")->where("id", $user_id)->first();
        $emojis = Emoji::select("*")->get();
        $userChats = UserChatsService::getRecentChats($user_id);

        $streamToken = $user->stream_token;
        if (count($userChats) != 0) {
            return view("/public/user/userAccountChats", compact("userChats", "user_id", "innocreationChat", "streamToken", "emojis", 'pageType'));
        }
        return view("/public/user/userAccountChats", compact("user_id", "inn", "streamToken", "emojis", 'pageType'));
    }

    public function deleteChat($request){
        $userChatId = $request->input("user_chat_id");

        $userMessages = UserMessage::select("*")->where("user_chat_id", $userChatId)->get();
        if(count($userMessages) > 0) {
            foreach ($userMessages as $userMessage) {
                $userMessage->delete();
            }
        }
        $userChat = UserChat::select("*")->where("id", $userChatId)->first();
        $userChat->delete();
        if(Session::has("userChatId")) {
            Session::remove("userChatId");
        }

        return redirect("/my-account/chats");
    }

    public function searchChats($request){
        // gets all the users where user searched on to chat with
        $user_id = Session::get("user_id");
        $searchInput = $request->input("searchChatUsers");
        $emojis = Emoji::select("*")->get();

        $userChats = UserChat::select("*")->where("creator_user_id", $user_id)->orWhere("receiver_user_id", $user_id)->get();
        if (strlen($searchInput) > 0) {
            $idArray = [];
            foreach ($userChats as $userChat) {
                if($userChat->creator_user_id == $user_id){
                    $name = $userChat->receiver->getName();
                } else if($userChat->creator_user_id == 1) {
                    $name = "Innocreation";
                } else {
                    $name = $userChat->creator->getName();
                }
                if (strpos($name, ucfirst($searchInput)) !== false) {
                    array_push($idArray, $userChat->id);
                }
            }
            $searchedUserChats = UserChat::select("*")->whereIn("id", $idArray)->get();
        } else {
            $searchInput = false;
        }
        $user = User::select("*")->where("id", $user_id)->first();
        $streamToken = $user->stream_token;
        if(strlen($searchInput) < 1){
            return redirect("/my-account/chats");
        }

        $searchedUserChats = self::getUserChatArray($searchedUserChats, $user_id);
        return view("/public/user/userAccountChats", compact("searchedUserChats", "user_id", "streamToken", "emojis"));
    }

    public function selectChat($request){
        $receiver_user_id = $request->input("receiver_user_id");
        $creator_user_id = $request->input("creator_user_id");

        $existingUserChat = UserChat::select("*")->where("receiver_user_id", $receiver_user_id)->where("creator_user_id", $creator_user_id)->orWhere("receiver_user_id", $creator_user_id)->where("creator_user_id", $receiver_user_id)->get();
        if (count($existingUserChat) < 1) {
            $userChat = new UserChat();
            $userChat->creator_user_id = $creator_user_id;
            $userChat->receiver_user_id = $receiver_user_id;
            $userChat->created_at = date("Y-m-d H:i:s");
            $userChat->save();

            Session::set("userChatId", $userChat->id);
            return redirect("/my-account/chats");
        }
        $id = $existingUserChat->First()->id;
        Session::set("userChatId", $id);
        return redirect("/my-account/chats");
    }

    public function sendMessage($request, $stream, $mailgun){
        // sends a message to the user. The user selected. with the sended time and return to the page with id.
        // so the collapse stays open from the user you are chatting with
        $user_chat_id = $request->input("user_chat_id");
        $sender_user_id = $request->input("sender_user_id");
        $message = $request->input("message");

        $timeSent = new TimeSent();

        $messageArray = ["message" => $message, "timeSent" => $timeSent->time];

        $userChat = UserChat::select("*")->where("id", $user_chat_id)->first();

        if(strlen($message) > 0 && $message != "") {
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = $sender_user_id;
            $userMessage->user_chat_id = $user_chat_id;
            $userMessage->time_sent = $timeSent->time;
            $userMessage->message = $request->input("message");
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();


            if ($userChat->receiver_user_id == $sender_user_id) {
                $receiverId = $userChat->creator_user_id;
            } else {
                $receiverId = $userChat->receiver_user_id;
            }
            // Add the activity to the feed
            $data = ["actor" => $receiverId, "receiver" => $sender_user_id, "userChat" => $user_chat_id, "message" => "$message", "timeSent" => "$timeSent->time", "verb" => "userMessage", "object" => "3",];
            $stream->addActivityToFeed($receiverId, $data);

            if ($receiverId != 1) {
                $user = User::select("*")->where("id", $receiverId)->first();
                $mailgun->saveAndSendEmail($user, "You have gotten a message!", view("/templates/sendChatNotification", compact("user")));
            }

        }
        return json_encode($messageArray);
    }


    public static function getRecentChats($userId){
        // Creating userchat empty array

        $userChats = UserChat::select("*")->where("creator_user_id", $userId)->orWhere("receiver_user_id", $userId)->get();

        //Foreach all userChats of user and pushing them in a array + the sended date and recentchat
        $userchats = self::getUserChatArray($userChats, $userId);
        // sorting all the userChats on sender date so most recent one is on top
        usort($userchats, function($a, $b) {
            return ($a['timeSentLast'] > $b['timeSentLast']) ? -1 : 1;
        });

        //returning all chats
        return $userchats;
    }

    private static function getUserChatArray($userChats, $userId){
        $userchats = [];
        foreach($userChats as $userChat) {
            if($userChat->creator_user_id == $userId) {
                $user = $userChat->receiver;
                $receiver = $userChat->creator;
            } else if($userChat->creator_user_id == 1) {
                $user = self::createInnoClass();
            } else {
                $user = $userChat->creator;
                $receiver = $userChat->receiver;
            }

            $recentChat = $userChat->getMostRecentMessage();
            $emptyRecentChat = new emptyRecentChat($user->id);
            if(isset($recentChat->message) && strlen($recentChat->message) != 0) {
                array_push($userchats, array('userchat' => $userChat, 'timeSentLast' => date("Y-m-d H:i:s", strtotime($recentChat->created_at)), "recentChat" => $recentChat, 'user' => $user));
            } else {
                array_push($userchats, array('userchat' => $userChat, 'timeSentLast' => date("Y-m-d H:i:s"), "recentChat" => $emptyRecentChat, 'user' => $user));
            }
        }

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
        \Session::set("userChatId", $userChat->id);
        $user_id = $userId;
        return view("/public/shared/messages/_messagesUserChat", compact("user_id", "userChat", "admin", "userMessages"));
    }

    public static function getUserChatReceiver($receiverUserId, $userChatId){
        if($receiverUserId != 1) {
            $receiver = User::select("*")->where("id", $receiverUserId)->first();
            $today = new \DateTime(date("Y-m-d H:i:s"));
            $date = new \DateTime(date("Y-m-d H:i:s", strtotime($receiver->online_timestamp)));
            $interval = $date->diff($today);
            return view("/public/shared/messages/_receiverUserChat", compact("receiver", "interval", "userChatId", "receiverUserId"));
        } else {
            $receiver = $user = self::createInnoClass();
            return view("/public/shared/messages/_receiverUserChat", compact(  "receiver", "userChatId", "receiverUserId"));
        }
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

    private static function createInnoClass(){
        $user = new InnoClass();
        return $user;
    }
}