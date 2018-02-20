<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first(); // gets the user who is logged in at the moment
        $topTeams = Team::select("*")->orderBy("support","DESC")->limit(3)->get(); // gets the top 3 teams ordered by Support points descending
        return view("/public/home/teamSearch",compact("topTeams", "user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchTeamsAction(Request $request)
    {
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
                return view("/public/home/teamSearch", compact("searchedTeams", "topTeams", "user"));
            } else {
                return redirect("/teams");
            }
        } else {
            $topTeams = Team::select("*")->orderBy("support", "DESC")->limit(3)->get();
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $searchedTeams = Team::select("*")->get();
            return view("/public/home/teamSearch", compact("searchedTeams", "topTeams", "user"));
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
