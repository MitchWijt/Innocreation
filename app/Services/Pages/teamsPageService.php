<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 04/04/2019
 * Time: 18:29
 */
namespace App\Services\Pages;
class teamsPageService {

    public static function getTeamsInNeedOfExpertise($teams, $user){
        return view("/public/pages/shared/_teamsPageTeamsInNeedOfExpertise", compact("teams", "user"));
    }

    public static function getAllTeams($teams){
        return view("/public/pages/shared/_teamsPageAllTeams", compact("teams"));
    }
}