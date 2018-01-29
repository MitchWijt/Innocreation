<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

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
        $topTeams = Team::select("*")->orderBy("support","DESC")->limit(3)->get();
        return view("/public/home/teamSearch",compact("topTeams"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchTeamsAction(Request $request)
    {
        $topTeams = Team::select("*")->orderBy("support","DESC")->limit(3)->get();

        $searchedTeam = $request->input("searchTeams");
        if($searchedTeam != "") {
            $teamIdArray = [];
            $teams = Team::select("*")->get();
            foreach ($teams as $team) {
                if (strpos($team, ucfirst($searchedTeam)) !== false) {
                    array_push($teamIdArray, $team->id);
                }
            }
            $searchedTeams = Team::select("*")->whereIn("id", $teamIdArray)->get();
            return view("/public/home/teamSearch", compact("searchedTeams", "topTeams"));
        } else {
            return redirect("/teams");
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
