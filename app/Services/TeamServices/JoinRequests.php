<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 13/01/2019
 * Time: 10:49
 */

namespace App\Services\TeamServices;


use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
use App\Services\TimeSent;
use App\Team;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Support\Facades\Session;

class JoinRequests
{
    public function joinRequestsIndex(){
        // gets all the join requests for the team
        $user_id = Session::get("user_id");
        $team_id = Session::get("team_id");
        $userJoinRequests = JoinRequestLinktable::select("*")->where("team_id", $team_id)->get();
        $invites = InviteRequestLinktable::select("*")->where("team_id", $team_id)->get();
        return view("/public/team/teamUserJoinRequests", compact("userJoinRequests", "user_id", "invites"));
    }

    public function inviteUser($request, $mailgunService){
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");

        $checkJoinInvites = InviteRequestLinktable::select("*")->where("team_id",$team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($checkJoinInvites) == 0) {
            $team = Team::select("*")->where("id", $team_id)->first();

            $invite = new InviteRequestLinktable();
            $invite->team_id = $team_id;
            $invite->user_id = $user_id;
            $invite->expertise_id = $expertise_id;
            $invite->accepted = 0;
            $invite->created_at = date("Y-m-d");
            $invite->save();

            $userFirstName = $invite->users->First()->firstname;
            $timeNow = date("H:i:s");
            $time = (date("g:i a", strtotime($timeNow)));

            $existingUserChat = UserChat::select("*")->where("creator_user_id", $user_id)->where("receiver_user_id",  $invite->teams->ceo_user_id)->orWhere("creator_user_id",  $invite->teams->ceo_user_id)->where("receiver_user_id", $user_id)->get();
            if(count($existingUserChat) < 1){
                $userChat = new UserChat();
                $userChat->creator_user_id = $invite->teams->ceo_user_id;
                $userChat->receiver_user_id = $user_id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $userChatId = $userChat->id;
            } else {
                $userChatId = $existingUserChat->First()->id;
            }
            $message = new UserMessage();
            $message->sender_user_id = $invite->teams->ceo_user_id;
            $message->user_chat_id = $userChatId;
            $message->message = "Hey $userFirstName I have done an invite to you to join my team!";
            $message->time_sent = $time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $receiver = User::select("*")->where("id", $user_id)->first();

            $mailgunService->saveAndSendEmail($receiver, "Team invite from $team->team_name!", view("/templates/sendInviteToUserMail", compact("receiver", "team")));
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already sent an invite to this user");
        }
    }

    public function rejectUser($request, $streamService){
        // Rejects user from team
        // sends user a message for rejection
        $request_id = $request->input("request_id");
        $request = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
        $request->accepted = 2;
        $request->save();

        $userName = $request->user->getName();
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $userChat = UserChat::select("*")->where("creator_user_id", $request->user_id)->first();
        $message = new UserMessage();
        $message->sender_user_id = $request->team->ceo_user_id;
        $message->user_chat_id = $userChat->id;
        $message->message = "Hey $userName unfortunately we decided to reject you from our team";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $notificationMessage = sprintf("%s has declined your request to join their team", $request->team->team_name);
        $timeSent = new TimeSent();
        $data = ["actor" => $request->user_id, "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3"];
        $streamService->addActivityToFeed($request->user_id, $data);


        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function acceptUser($request, $streamService){
        // accepts user into team
        // sends user message that he is welcome in team
        // checks if user is requested for any other team. and rejects the user at that team

        $user_id = $request->input("user_id");
        $request_id = $request->input("request_id");
        $expertise_id = $request->input("expertise_id");
        $team_id = $request->input("team_id");
        $joinRequest = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
        $joinRequest->accepted = 1;
        $joinRequest->save();

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->amount = $neededExpertise->amount - 1;
        $neededExpertise->save();

        $otherRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->where("accepted", 0)->get();
        if (count($otherRequests) > 0) {
            foreach ($otherRequests as $otherRequest) {
                $otherRequest->accepted = 2;
                $otherRequest->save();
            }
        }

        $userName = $joinRequest->user->getName();
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $user = User::select("*")->where("id", $joinRequest->user->id)->first();
        $user->team_id = $joinRequest->team_id;
        $user->subscription_canceled = 0;
        $user->save();

        $existingUserChat = UserChat::select("*")->where("creator_user_id", $user->id)->where("receiver_user_id",  $joinRequest->team->ceo_user_id)->orWhere("creator_user_id",  $joinRequest->team->ceo_user_id)->where("receiver_user_id", $user->id)->first();
        if(count($existingUserChat) < 1){
            $userChat = new UserChat();
            $userChat->creator_user_id = $joinRequest->team->ceo_user_id;
            $userChat->receiver_user_id = $user->id;
            $userChat->created_at = date("Y-m-d H:i:s");
            $userChat->save();

            $userChatId = $userChat->id;
        } else {
            $userChatId = $existingUserChat->id;
        }
        $message = new UserMessage();
        $message->sender_user_id = $joinRequest->team->ceo_user_id;
        $message->user_chat_id = $userChatId;
        $message->message = "Hey $userName we are happy to say, that we accepted you in our team. Welcome!";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $notificationMessage = sprintf("%s has declined your request to join their team", $joinRequest->team->team_name);
        $timeSent = new TimeSent();
        $data = ["actor" => $joinRequest->user_id, "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3"];
        $streamService->addActivityToFeed($joinRequest->user_id, $data);

        return redirect($_SERVER["HTTP_REFERER"]);
    }
}