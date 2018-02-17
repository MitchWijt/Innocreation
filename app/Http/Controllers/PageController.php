<?php

namespace App\Http\Controllers;

use App\Expertises_linktable;
use App\FavoriteTeamLinktable;
use App\Team;
use App\TeamReview;
use App\User;
use App\JoinRequestLinktable;
use App\UserPortfolio;
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
    public function singleUserPageIndex($firstname = null, $middlename = null, $lastname = null)
    {
        if($lastname == null){
            // middlename is lastname here
            $user  = User::select("*")->where("firstname", ucfirst($firstname))->where("lastname", ucfirst($middlename))->first();
        } else {
            // everything is normal
            $user  = User::select("*")->where("firstname", ucfirst($firstname))->where("middlename", $middlename)->where("lastname", ucfirst($lastname))->first();
        }

        $loggedIn = User::select("*")->where("id", Session::get("user_id"))->first();
        $expertise_linktable = Expertises_linktable::select("*")->where("user_id", $user->id)->get();
        $portfolios = UserPortfolio::select("*")->where("user_id", $user->id)->get();
        return view("public/pages/singleUserPage", compact("user","expertise_linktable", "loggedIn", "portfolios"));
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
