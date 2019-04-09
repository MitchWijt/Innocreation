<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 12/01/2019
 * Time: 17:40
 */

namespace App\Services\UserAccount;


use App\Http\Requests\Request;
use App\InviteRequestLinktable;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
use App\Services\TimeSent;
use App\Team;
use App\TeamCreateRequest;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Support\Facades\Session;

class UserRequestsService
{
    public function applyForTeam($request, $mailgun){
        // sends a join request to the team.
        // users applies for the team.
        $team_id = $request->input("team_id");
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $timeSent = new TimeSent();

        $user = User::select("*")->where("id", $user_id)->first();

        $checkJoinRequests = JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if (count($checkJoinRequests) == 0) {
            $team = Team::select("*")->where("id", $team_id)->first();

            $joinRequest = new JoinRequestLinktable();
            $joinRequest->team_id = $team_id;
            $joinRequest->user_id = $user_id;
            $joinRequest->expertise_id = $expertise_id;
            $joinRequest->accepted = 0;
            $joinRequest->created_at = date("Y-m-d");
            $joinRequest->save();

            $ceoFirstname = $team->users->firstname;

            $existingUserChat = UserChat::select("*")->where("creator_user_id", $user_id)->where("receiver_user_id",  $joinRequest->team->ceo_user_id)->orWhere("creator_user_id",  $joinRequest->team->ceo_user_id)->where("receiver_user_id", $user_id)->first();
            if(count($existingUserChat) < 1){
                $userChat = new UserChat();
                $userChat->creator_user_id = $user_id;
                $userChat->receiver_user_id = $joinRequest->team->ceo_user_id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                $userChatId = $userChat->id;
            } else {
                $userChatId = $existingUserChat->id;
            }
            $message = new UserMessage();
            $message->sender_user_id = $user_id;
            $message->user_chat_id = $userChatId;
            $message->message = "Hey $ceoFirstname I have done a request to join your team!";
            $message->time_sent = $timeSent->time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $userChatInno = UserChat::select("*")->where("creator_user_id", 1)->where("receiver_user_id", $user_id)->first();
            $message = new UserMessage();
            $message->sender_user_id = 1;
            $message->user_chat_id = $userChatInno->id;
            $message->message = sprintf("Hello %s, <br> You've recently requested to join the team %s. <br> Amazing step forward!<br> You will be notified when the team alters the status of your request. <br><br> Goodluck!", $user->getName(), $team->team_name);
            $message->time_sent = $timeSent->time;
            $message->created_at = date("Y-m-d H:i:s");
            $message->save();

            $user = User::select("*")->where("id", $user_id)->first();
            $mailgun->saveAndSendEmail($joinRequest->team->users, "Team join request from $user->firstname!", view("/templates/sendJoinRequestToTeam", compact("user", "team")));

            if($request->input("register")){
                return redirect("/my-account/team-join-requests");
            } else {
                return redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            if($request->input("register")){
                return redirect($user->getUrl())->withErrors("You already applied for this team");
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("You already applied for this team");
            }
        }
    }

    public function acceptInvite($request, $mailgun){
        // user accepts the team invite
        // Sends a message to the team.
        // Rejects any other invite sent to the user
        $user_id = $request->input("user_id");
        $invite_id = $request->input("invite_id");
        $expertise_id = $request->input("expertise_id");
        $team_id = $request->input("team_id");

        $invite = InviteRequestLinktable::select("*")->where("id", $invite_id)->first();
        $invite->accepted = 1;
        $invite->save();

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->amount = $neededExpertise->amount - 1;
        $neededExpertise->save();

        $otherInvites = InviteRequestLinktable::select("*")->where("user_id", $user_id)->where("accepted", 0)->get();
        if (count($otherInvites) > 0) {
            foreach ($otherInvites as $otherInvite) {
                $otherInvite->accepted = 2;
                $otherInvite->save();
            }
        }

        $teamCreateRequests = TeamCreateRequest::select("*")->where("receiver_user_id", $user_id)->where("accepted", 0)->get();
        if(count($teamCreateRequests)){
            foreach($teamCreateRequests as $teamCreateRequest){
                $teamCreateRequest->accepted = 2;
                $teamCreateRequest->save();
            }
        }

        $teamName = $invite->teams->First()->team_name;

        $user = User::select("*")->where("id", $invite->users->First()->id)->first();
        $user->team_id = $invite->team_id;
        $user->save();
        Session::set('team_id', $user->team_id);
        Session::set('team_name', $user->team->team_name);


        $timeSent = new TimeSent();
        $message = new UserMessage();
        $message->sender_user_id = $user->id;
        $message->team_id = $team_id;
        $message->message = "Hey $teamName i am happy to say, that i accepted your invite to join this team.";
        $message->time_sent = $timeSent->time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $team = Team::select("*")->where("id", $team_id)->first();

        $mailgun->saveAndSendEmail($team->users,  "Accepted invitation!", view("/templates/sendInviteAcceptionTeam", compact("user", "team")));

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function declineInvite($request){
        //rejects the team invite sent to the user + sends a message to the CEO of the team.
        $invite_id = $request->input("invite_id");
        $invite = InviteRequestLinktable::select("*")->where("id", $invite_id)->first();
        $invite->accepted = 2;
        $invite->save();

        $ceo = User::select("*")->where("id", $invite->teams->ceo_user_id)->First();
        $ceoName = $ceo->getName();
        $time = new TimeSent();

        $existingUserChat = UserChat::select("*")->where("creator_user_id", $invite->user_id)->where("receiver_user_id", $invite->teams->ceo_user_id)->orWhere("creator_user_id", $invite->teams->ceo_user_id)->where("receiver_user_id", $invite->user_id)->first();
        if(count($existingUserChat) > 0){
            $userChat = $existingUserChat;
        } else {
            $userChat = new UserChat();
            $userChat->creator_user_id = $invite->user_id;
            $userChat->receiver_user_id = $invite->teams->ceo_user_id;
            $userChat->created_at = date("Y-m-d H:i:s");
            $userChat->save();
        }

        $message = new UserMessage();
        $message->sender_user_id = $invite->user_id;
        $message->message = "Hey $ceoName I decided to reject your invite";
        $message->time_sent = $time->time;
        $message->user_chat_id = $userChat->id;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }
}