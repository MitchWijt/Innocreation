<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 16-10-18
 * Time: 19:18
 */
namespace App\Services\TeamServices;
use App\Team;

class CredentialService
{
    private $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function saveTeamName($request){
        $teamName = ucfirst($request->input("newTeamName"));
        $id = $request->input("teamId");

        $team = Team::select("*")->where("id", $id)->first();

        if(Team::select("*")->where("team_name", $teamName)->first() && $team->team_name != $teamName){
            return 1;
        }

        $team->team_name = $teamName;
        $team->save();
        return 0;
    }

    public function getPrivacySettingsModal($request){
        $team = Team::select("*")->where("id", $request->input("team_id"))->first();
        return view("/public/team/shared/_teamPrivacySettingsModal", compact("team"));
    }
}