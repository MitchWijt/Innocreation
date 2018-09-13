<?php

namespace App\Http\Controllers;

use App\CollaborateChatMessage;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class CollaborateController extends Controller{

    public function indexAction(){
        $messages = CollaborateChatMessage::select("*")->get();
        if(Session::has("user_id")){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/collaborateChat/index", compact("messages", "user"));
        } else {
            return view("/public/collaborateChat/index", compact("messages"));
        }
    }

    public function sendMessageAction(Request $request){
        $senderUserId = $request->input("sender_user_id");
        $message = $request->input("message");

        if($message != "" || !empty($message)) {
            $user = User::select("*")->where("id", $senderUserId)->first();

            $collaborationMessage = new CollaborateChatMessage();
            $collaborationMessage->sender_user_id = $senderUserId;
            $collaborationMessage->message = $message;
            $collaborationMessage->time_sent = $this->getTimeSent();
            $collaborationMessage->popover_html = $user->getPopoverView();
            $collaborationMessage->created_at = date("Y-m-d H:i:s");
            $collaborationMessage->save();

            $array = ["message" => $message, "timeSent" => $this->getTimeSent()];


            $client = $this->getService("stream");
            if ($user->team_id != null) {
                $data = [
                    "actor" => "1",
                    "name" => $user->getName(),
                    "userId" => $user->id,
                    "team" => $user->team->team_name,
                    "popoverView" => "$collaborationMessage->popover_html",
                    "timeSent" => $this->getTimeSent(),
                    "message" => $message,
                    "verb" => "collaborationMessage",
                    "object" => "1",
                ];
            } else {
                $data = [
                    "actor" => "1",
                    "name" => $user->getName(),
                    "userId" => $user->id,
                    "team" => 0,
                    "popoverView" => "$collaborationMessage->popover_html",
                    "timeSent" => $this->getTimeSent(),
                    "message" => $message,
                    "verb" => "collaborationMessage",
                    "object" => "1",
                ];
            }
            $adminFeed = $client->feed('user', 1);
            $adminFeed->addActivity($data);
            return json_encode($array);
        }
    }
}
