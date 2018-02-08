<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\JoinRequestLinktable;
use App\NeededExpertiseLinktable;
use App\Team;
use App\User;
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
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        return view("/public/team/teamPageCredentials", compact("team"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveTeamProfilePictureAction(Request $request)
    {
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
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $expertises = Expertises::select("*")->get();
        return view("/public/team/neededExpertisesTeam", compact("team","expertises"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNeededExpertiseAction(Request $request)
    {
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
    public function deleteNeededExpertiseAction(Request $request)
    {
        $team_id = $request->input("team_id");
        $expertise_id = $request->input("expertise_id");

        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team_id)->where("expertise_id", $expertise_id)->first();
        $neededExpertise->delete();
        return 1;
    }
}
