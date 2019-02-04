<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 14-10-18
 * Time: 11:05
 */

namespace App\Services\FeedServices;

use App\ConnectRequestLinktable;
use App\Services\TimeSent;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserWork;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;

class SwitchUserWork
{
    public function createNewConnectRequest($request, $streamService)
    {
        $connectRequest = new ConnectRequestLinktable();
        $connectRequest->receiver_user_id = $request->input("receiverId");
        $connectRequest->sender_user_id = $request->input("senderId");
        $connectRequest->accepted = 0;
        $connectRequest->created_at = date("Y-m-d H:i:s");
        $connectRequest->save();

        $receiver = User::select("*")->where("id", $connectRequest->receiver_user_id)->first();
        $notificationMessage = sprintf("A connection request has been sent to %s", $receiver->firstname);
        $timeSent = new TimeSent();
        $data = ["actor" => $connectRequest->sender_user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3"];
        $streamService->addActivityToFeed($connectRequest->sender_user_id, $data);
        return 1;
    }

    public function listConnections($id)
    {
        $connections = ConnectRequestLinktable::select("*")
            ->where("receiver_user_id", $id)
            ->orWhere("sender_user_id", $id)->get();
        return $connections;
    }

    public function listAcceptedConnections($id)
    {
        $connections = ConnectRequestLinktable::select("*")
            ->where("receiver_user_id", $id)
            ->orWhere("sender_user_id", $id)
            ->where("accepted", 1)
            ->get();
        return $connections;
    }

    public function listConnectionRequests($id){
        $connections = ConnectRequestLinktable::select("*")
            ->where("receiver_user_id", $id)
            ->where("sender_user_id", "!=", $id)
            ->where("accepted", 0)
            ->get();
        return $connections;
    }

    public function acceptConnection($request, $mailgun, $streamService)
    {
        $connectRequest = ConnectRequestLinktable::select("*")
            ->where("id", $request->input("connection_id"))->first();
        $connectRequest->accepted = 1;
        $connectRequest->save();

        $existingUserChat = UserChat::select("*")
            ->where("receiver_user_id", $connectRequest->sender_user_id)
            ->where("creator_user_id", $connectRequest->receiver_user_id)
            ->orWhere("receiver_user_id", $connectRequest->receiver_user_id)
            ->where("creator_user_id", $connectRequest->sender_user_id)->first();
        if (count($existingUserChat) < 1) {
            $userChat = new UserChat();
            $userChat->creator_user_id = $connectRequest->receiver_user_id;
            $userChat->receiver_user_id = $connectRequest->sender_user_id;
            $userChat->created_at = date("Y-m-d H:i:s");
            $userChat->save();
        } else {
            $userChat = $existingUserChat;
        }

        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $mailgun->getTimeSent();
        $userMessage->message = 'You have been connected with each other! <br> Get to know each other some more';
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();

        $user = $connectRequest->sender;
        $mailgun->saveAndSendEmail($connectRequest->sender, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));

        $user = $connectRequest->user;
        $mailgun->saveAndSendEmail($connectRequest->user, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));


        $notificationMessage = sprintf("Your connection request to %s has been accepted!", $connectRequest->user->firstname);
        $timeSent = new TimeSent();
        $data = ["actor" => $connectRequest->sender_user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3"];
        $streamService->addActivityToFeed($connectRequest->sender_user_id, $data);

        Session::set("userChatId", $userChat->id);
    }

    public function declineConnection($request, $mailgun, $streamService)
    {
        $connectRequest = ConnectRequestLinktable::select("*")->where("id", $request->input("connection_id"))->first();
        $connectRequest->accepted = 2;
        $connectRequest->save();

        $userChat = UserChat::select("*")
            ->where("receiver_user_id", $connectRequest->sender_user_id)->where("creator_user_id", 1)->first();
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $mailgun->getTimeSent();
        $userMessage->message = sprintf('%s has declined your request to connect. Visit the feed to connect with more like-minded people!', $connectRequest->user->firstname);
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();

        $user = $connectRequest->sender;

        $mailgun->saveAndSendEmail($connectRequest->sender, 'You have got a message!', view("/templates/sendChatNotification", compact("user")));

        $notificationMessage = sprintf("Your connection request to %s has been accepted!", $connectRequest->user->firstname);
        $timeSent = new TimeSent();
        $data = ["actor" => $connectRequest->sender_user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3"];
        $streamService->addActivityToFeed($connectRequest->sender_user_id, $data);

        return redirect($user->getUrl());
    }
}
