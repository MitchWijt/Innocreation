<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 02/04/2019
 * Time: 18:01
 */

namespace App\Services\TeamServices;


use App\Expertises;
use App\NeededExpertiseLinktable;
use App\Team;

class TeamExpertisesService {
    public function getEditNeededExpertiseModal($request){
        $expertises = Expertises::select("*")->get();
        $team = Team::select("*")->where("id", $request->input("teamId"))->first();
        if($request->input("neededExpertiseId")){
            $neededExpertise = NeededExpertiseLinktable::select("*")->where("id", $request->input("neededExpertiseId"))->first();
            return view("/public/team/shared/_teamEditNeededExpertisesModal", compact("neededExpertise", "expertises", "team"));
        } else {
            return view("/public/team/shared/_teamEditNeededExpertisesModal", compact("expertises", "team"));
        }
    }

    public function saveNeededExpertises($request){
        // saves the description + requirements for the expertises the team decided to change
        if($request->input("neededExpertiseId")){
            self::editExistingNeededExpertise($request);
        } else {
            self::createNewNeededExpertise($request);

        }

        $team = Team::select("*")->where("id", $request->input("team_id"))->first();
        return redirect($team->getUrl());
    }

    private static function createNewNeededExpertise($request){
        $neededExpertise = new NeededExpertiseLinktable();
        $neededExpertise->team_id = $request->input("team_id");
        $neededExpertise->expertise_id = $request->input("expertise_id");
        $neededExpertise->requirements = $request->input("requirements");
        $neededExpertise->description = $request->input("description_needed_expertise");
        $neededExpertise->amount = $request->input("amount");
        $neededExpertise->save();
    }

    private static function editExistingNeededExpertise($request){
        $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $request->input("team_id"))->where("expertise_id", $request->input("expertise_id"))->first();
        $neededExpertise->requirements = $request->input("requirements");
        $neededExpertise->description = $request->input("description_needed_expertise");
        $neededExpertise->amount = $request->input("amount");
        $neededExpertise->save();
    }

    public static function getMaxNeededExpertises($team){
        $neededExpertises = NeededExpertiseLinktable::select("*")->where("team_id", $team->id)->limit(4)->get();
        return $neededExpertises;

    }

}