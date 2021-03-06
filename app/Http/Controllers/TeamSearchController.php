<?php

namespace App\Http\Controllers;

use App\NeededExpertiseLinktable;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Session;

use App\Http\Requests;

class TeamSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = "Find your team and participate with an idea!";
        $og_description = "Search and find a creative and innovative team and help build their idea/dream!";
        $user = User::select("*")->where("id", Session::get("user_id"))->first(); // gets the user who is logged in at the moment
        $teams = Team::select("*")->get(); // gets the top 3 teams ordered by Support points descending
        return view("/public/pages/teamsPage",compact("teams", "user", "title", "og_description"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchTeamsAction(Request $request){
        if($request->input("allTeamsSearch") == null) {
            $topTeams = Team::select("*")->orderBy("support", "DESC")->limit(3)->get();
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $searchedTeam = $request->input("searchTeams");
            if ($searchedTeam != "") { // checks if the search input is empty
                $teamIdArray = [];
                $teams = Team::select("*")->get();
                foreach ($teams as $team) {
                    if (strpos($team, ucfirst($searchedTeam)) !== false) { //gets all the teams which the user searched on
                        array_push($teamIdArray, $team->id);
                    }
                }
                $searchedTeams = Team::select("*")->whereIn("id", $teamIdArray)->get(); // all the teams where users searched on

                $allNeededExpertises = $this->getAllNeededExpertises();
                return view("/public/home/teamSearch", compact("searchedTeams", "topTeams", "user", "allNeededExpertises"));
            } else {
                $temp = [];
                if($request->input("expertiseSearch") != null){
                    $neededExpertises = NeededExpertiseLinktable::select("*")->where("expertise_id", $request->input("expertiseSearch"))->get();
                    foreach($neededExpertises as $neededExpertise){
                        array_push($temp, $neededExpertise->team_id);
                    }
                    $expertiseTeamIds = array_unique($temp);
                    $searchedTeams = Team::select("*")->whereIn("id", $expertiseTeamIds)->get();
                    $allNeededExpertises = $this->getAllNeededExpertises();

                    return view("/public/home/teamSearch", compact("searchedTeams", "topTeams", "user", "allNeededExpertises"));
                } else {
                    return redirect("/teams");
                }
            }
        } else {
            $topTeams = Team::select("*")->orderBy("support", "DESC")->limit(3)->get();
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $searchedTeams = Team::select("*")->get();
            $allNeededExpertises = $this->getAllNeededExpertises();
            return view("/public/home/teamSearch", compact("searchedTeams", "topTeams", "user", "allNeededExpertises"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
