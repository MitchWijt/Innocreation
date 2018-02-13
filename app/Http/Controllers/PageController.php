<?php

namespace App\Http\Controllers;

use App\FavoriteTeamLinktable;
use App\Team;
use App\TeamReview;
use App\User;
use App\JoinRequestLinktable;
use Illuminate\Http\Request;
use Session;

use App\Http\Requests;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleTeamPageIndex(Request $request, $team_name)
    {
        // gets the team from the url team_name

        $acceptedJoinRequests = JoinRequestLinktable::select("*")->where("accepted", 1)->get();
        $acceptedExpertises = [];
        foreach($acceptedJoinRequests as $acceptedJoinRequest){
            array_push($acceptedExpertises, $acceptedJoinRequest->expertise_id);
        }
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("team_name", $team_name)->first();
        $reviews = TeamReview::select("*")->where("team_id", $team->id)->get();
        if($user) {
            $favoriteTeam = FavoriteTeamLinktable::select("*")->where("team_id", $team->id)->where("user_id", $user->id)->first();
        }
        return view("/public/pages/singleTeamPage", compact("team","user", "acceptedExpertises", "favoriteTeam", "reviews"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
