<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 14-10-18
 * Time: 11:05
 */

namespace App\Services\FeedServices;

use App\ConnectRequestLinktable;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserWork;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;

class SwitchUserWork
{
    private $modal;
    private $requestModal;

    public function __construct(UserWork $userWork, ConnectRequestLinktable $connectRequest)
    {
        $this->modal = $userWork;
        $this->requestModal = $connectRequest;
    }

    public function createNewConnectRequest($request)
    {
        $connectRequest = new $this->requestModal;
        $connectRequest->receiver_user_id = $request->input("receiver_user_id");
        $connectRequest->sender_user_id = $request->input("sender_user_id");
        $connectRequest->message = $request->input("connectMessage");
        $connectRequest->accepted = 0;
        $connectRequest->created_at = date("Y-m-d H:i:s");
        $connectRequest->save();

        return json_encode($connectRequest);
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

    public function acceptConnection($request, $mailgun)
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


        Session::set("userChatId", $userChat->id);
    }

    public function declineConnection($request, $mailgun)
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
    }
}
