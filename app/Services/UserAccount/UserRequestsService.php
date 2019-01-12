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
use App\NeededExpertiseLinktable;
use App\Services\TimeSent;
use App\Team;
use App\TeamCreateRequest;
use App\User;
use App\UserMessage;
use Illuminate\Support\Facades\Session;

class UserRequestsService
{
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
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $message = new UserMessage();
        $message->sender_user_id = $invite->user_id;
        $message->message = "Hey $ceo I decided to reject your invite";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $message = new UserMessage();
        $message->sender_user_id = $invite->teams->ceo_user_id;
        $message->message = null;
        $message->time_sent = null;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }
}