<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\expertises_linktable;
use App\Favorite_expertises_linktable;
use App\Team;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccount()
    {
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccount", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAccountCredentials()
    {
        if(Session::has("user_name")) {
            $id = Session::get("user_id");
            $user = User::select("*")->where("id", $id)->first();
            return view("/public/user/userAccountCredentials", compact("user"));
        } else {
            return view("/public/home/home");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveUserAccount(Request $request)
    {
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $user->skype = $request->input("skype");
        $user->motivation = $request->input("motivation_user");
        $user->introduction = $request->input("introduction_user");
        $user->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userAccountExpertises()
    {
        $user_id = Session::get("user_id");
        $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        return view("/public/user/userAccountExpertises", compact("expertises_linktable"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveUserExpertiseDescription(Request $request)
    {
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $description = $request->input("userExpertiseDescription");

        $expertises = expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        $expertises->description = $description;
        $expertises->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teamBenefits()
    {
        $user_id = Session::get("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        return view("/public/user/teamBenefits", compact("user"));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createNewTeam(Request $request)
    {
        $team_name = $request->input("team_name");
        $user_id = $request->input("user_id");
        $all_teams = Team::select("*")->where("team_name", $team_name)->get();
        $user = User::select("*")->where("id", $user_id)->first();
        if(count($all_teams) != 0){
            $error = "This name already exists";
            return view("/public/user/teamBenefits", compact("error", "user"));
        } else {
            $team = new Team;
            $team->team_name = $team_name;
            $team->ceo_user_id = $user_id;
            $team->created_at = date("Y-m-d H:i:s");
            $team->save();

            $user->team_id = $team->id;
            $user->save();

            Session::set("team_id", $team->id);
            Session::set("team_name", $team->team_name);


            return redirect("/my-team");
        }
    }

    public function favoriteExpertisesUser(){
        $user_id = Session::get("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $expertises = Expertises::select("*")->inRandomOrder()->limit("6")->get();
        $favoriteExpertisesUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        return view("/public/user/favoriteExpertisesUser", compact("expertises", "user", "favoriteExpertisesUser"));
    }

    public function saveFavoriteExperisesUser(Request $request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $existingFavExpertises = Favorite_expertises_linktable::select("*")->where("user_id",$user_id)->where("expertise_id", $expertise_id)->first();
        $AllFavUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->get();
        if(count($AllFavUser) >= 4){
            return "max";
        } else {
            if (count($existingFavExpertises == 0)) {
                $favoriteExpertise = new Favorite_expertises_linktable;
                $favoriteExpertise->user_id = $user_id;
                $favoriteExpertise->expertise_id = $expertise_id;
                $favoriteExpertise->save();
                return $favoriteExpertise->expertise_id;
            } else {
                return 2;
            }
        }
    }
}
