<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
use App\Team;
use App\User;
use App\UserMessage;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamPageCredentials()
    {
        // gets the user and team and gives them to the view

        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        return view("/public/team/teamPageCredentials", compact("team","user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveTeamProfilePictureAction(Request $request)
    {
        // grabs the uploaded file moves it into the correct folder and adds it to the database for the team
        $team_id = $request->input("team_id");


        $file = $request->file("profile_picture");
        $destinationPath = public_path().'/images/profilePicturesTeams';
        $fullname = $file->getClientOriginalName();

        $team = Team::select("*")->where("id", $team_id)->first();
        $team->team_profile_picture = $fullname;
        $team->save();
        $file->move($destinationPath, $fullname);
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveTeamPageAction(Request $request)
    {
        // saves the description and motivation of the team (perhaps more in the future)
        $team_id = $request->input("team_id");

        $introduction = $request->input("introduction_team");
        $motivation = $request->input("motivation_team");

        $team = Team::select("*")->where("id", $team_id)->first();
        $team->team_introduction = $introduction;
        $team->team_motivation = $motivation;
        $team->updated_at = date("Y-m-d H:i:s");
        $team->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function neededExpertisesAction()
    {
        // gets all the needed expertised for the team
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $expertises = Expertises::select("*")->get();
        return view("/public/team/neededExpertisesTeam", compact("team","expertises", "user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNeededExpertiseAction(Request $request)
    {
        // Grabs the team id and expertise the team wants to add and adds it to the database for the team. Also checks for doubles
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertises");
        $expertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        if(count($expertise) == 0) {
            $neededExpertise = new NeededExpertiseLinktable();
            $neededExpertise->team_id = $team_id;
            $neededExpertise->expertise_id = $expertise_id;
            $neededExpertise->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            $error = "Already added this expertise. Please choose a new one";
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Already added this expertise. Please choose a new one");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveNeededExpertiseAction(Request $request)
    {
        // saves the description + requirements for the expertises the team decided to change
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertise_id");
        $requirements = $request->input("requirements");
        $description = $request->input("description_needed_expertise");
        $requirementString = "";
        foreach($requirements as $requirement){
            if($requirement != "") {
                if ($requirementString == "") {
                    $requirementString = $requirement;
                } else {
                    $requirementString = $requirementString . "," . $requirement;
                }
            }
        }

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->requirements = $requirementString;
        $neededExpertise->description = $description;
        $neededExpertise->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteNeededExpertiseAction(Request $request){
        // Grabs the needed expertise chosen and deletes the expertise from Database.

        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertise_id");

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->delete();
        return 1;
    }

    public function teamUserJoinRequestsAction(){
        // gets all the join requests for the team
        $user_id = Session::get("user_id");
        $team_id = Session::get("team_id");
        $userJoinRequests = JoinRequestLinktable::select("*")->where("team_id", $team_id)->get();
        return view("/public/team/teamUserJoinRequests", compact("userJoinRequests", "user_id"));
    }

    public function rejectUserFromTeamAction(Request $request){
        // Rejects user from team
        // sends user a message for rejection
        $request_id = $request->input("request_id");
        $request = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
        $request->accepted = 2;
        $request->save();

        $userName = $request->users->First()->getName();
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $message = new UserMessage();
        $message->sender_user_id = $request->teams->first()->ceo_user_id;
        $message->receiver_user_id = $request->users->first()->id;
        $message->message = "Hey $userName unfortunately we decided to reject you from our team";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $message = new UserMessage();
        $message->sender_user_id = $request->users->first()->id;
        $message->receiver_user_id = $request->teams->first()->ceo_user_id;
        $message->message = null;
        $message->time_sent = null;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    public function acceptUserInteamAction(Request $request){
        // accepts user into team
        // sends user message that he is welcome in team
        // checks if user is requested for any other team. and rejects the user at that team
        $user_id = $request->input("user_id");
        $request_id = $request->input("request_id");
        $request = JoinRequestLinktable::select("*")->where("id", $request_id)->first();
        $request->accepted = 1;
        $request->save();


        $otherRequests = JoinRequestLinktable::select("*")->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($otherRequests) > 0) {
            foreach ($otherRequests as $otherRequest) {
                $otherRequest->accepted = 2;
                $otherRequest->save();
            }
        }

        $userName = $request->users->First()->getName();
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));

        $user = User::select("*")->where("id", $request->users->First()->id)->first();
        $user->team_id = $request->team_id;
        $user->save();

        $message = new UserMessage();
        $message->sender_user_id = $request->teams->first()->ceo_user_id;
        $message->receiver_user_id = $request->users->first()->id;
        $message->message = "Hey $userName we are happy to say, that we accepted you in our team. Welcome!";
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $message = new UserMessage();
        $message->sender_user_id = $request->users->first()->id;
        $message->receiver_user_id = $request->teams->first()->ceo_user_id;
        $message->message = null;
        $message->time_sent = null;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();
        return redirect($_SERVER["HTTP_REFERER"]);

    }

    public function teamMembersPage(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        return view("/public/team/teamPageMembers", compact("team", "user"));
    }

    public function kickMemberFromTeamAction(Request $request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");
        $kickMessage = $request->input("kickMessage");

        $team = Team::select("*")->where("id", $team_id)->first();

        $user = User::select("*")->where("id", $user_id)->first();
        $user->team_id = null;
        $user->save();

        $joinrequest = JoinRequestLinktable::select("*")->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 1)->first();
        $joinrequest->delete();

        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $message = new UserMessage();
        $message->sender_user_id =  $team->ceo_user_id;
        $message->receiver_user_id = $user_id;
        $message->message = "Your kick reason: " . $kickMessage;
        $message->time_sent = $time;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        $message = new UserMessage();
        $message->sender_user_id = $user_id;
        $message->receiver_user_id = $team->ceo_user_id;
        $message->message = null;
        $message->time_sent = null;
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }
}
