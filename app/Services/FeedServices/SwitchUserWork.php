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

    public function __construct(UserWork $userWork, ConnectRequestLinktable $connectRequest) {
        $this->modal = $userWork;
        $this->requestModal = $connectRequest;

    }

    public function createNewConnectRequest($request){
        $connectRequest = new $this->requestModal;
        $connectRequest->receiver_user_id = $request->input("receiver_user_id");
        $connectRequest->sender_user_id = $request->input("sender_user_id");
        $connectRequest->user_work_id = $request->input("user_work_id");
        $connectRequest->message = $request->input("connectMessage");
        $connectRequest->accepted = 0;
        $connectRequest->created_at = date("Y-m-d H:i:s");
        $connectRequest->save();

        return json_encode($connectRequest);
    }

    public function listConnections($id){
        $connections = ConnectRequestLinktable::select("*")->where("receiver_user_id", $id)->orWhere("sender_user_id", $id)->get();
        return $connections;

    }

    public function acceptConnection($request, $mailgun){
        $connectRequest = ConnectRequestLinktable::select("*")->where("id", $request->input("connection_id"))->first();
        $connectRequest->accepted = 1;
        $connectRequest->save();

        $existingUserChat = UserChat::select("*")->where("receiver_user_id", $connectRequest->sender_user_id)->where("creator_user_id", $connectRequest->receiver_user_id)->orWhere("receiver_user_id", $connectRequest->receiver_user_id)->where("creator_user_id", $connectRequest->sender_user_id)->first();
        $userChat = $existingUserChat;
        if(count($existingUserChat) > 0) {
            $userchat = new UserChat();
            $userchat->creator_user_id = $connectRequest->receiver_user_id;
            $userchat->receiver_user_id = $connectRequest->sender_user_id;;
            $userchat->created_at = date("Y-m-d H:i:s");
            $userchat->save();
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

    public function declineConnection($request, $mailgun){
        $connectRequest = ConnectRequestLinktable::select("*")->where("id", $request->input("connection_id"))->first();
        $connectRequest->accepted = 2;
        $connectRequest->save();

        $userChat = UserChat::select("*")->where("receiver_user_id", $connectRequest->sender_user_id)->where("creator_user_id", 1)->first();
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