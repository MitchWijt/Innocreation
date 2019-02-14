<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 19/01/2019
 * Time: 07:42
 */

namespace App\Services\TeamServices;


use App\NeededExpertiseLinktable;
use App\Team;
use App\User;

class TeamPackage
{
    public static function checkPackageAndPayment($team_id, $expertise){
        $team = Team::select("*")->where("id", $team_id)->first();
        $neededExpertisesArray = [];
        $neededExpertises = NeededExpertiseLinktable::select("*")->where("team_id", $team->id)->where("amount", "!=", 0)->get();
        foreach ($neededExpertises as $neededExpertise) {
            array_push($neededExpertisesArray, $neededExpertise->expertise_id);
        }

         if(in_array($expertise->expertise_id, $neededExpertisesArray)) {
             if(!$team->packageDetails() || !$team->hasPaid()) {
                 if(count($team->getMembers()) >= 2) {
                     return false;
                 } else {
                    return true;
                 }
             } else {
                 if($team->hasPaid()) {
                     if($team->packageDetails()->custom_team_package_id == null) {
                         if($team->packageDetails()->membershipPackage->id == 3) {
                            return true;
                         } else if(count($team->getMembers()) >= $team->packageDetails()->membershipPackage->members) {
                             return false;
                         } else {
                           return true;
                         }
                     } else {
                         if(count($team->getMembers()) >= $team->packageDetails()->customTeamPackage->members && $team->packageDetails()->customTeamPackage->members != "unlimited") {
                             return true;
                         } else {
                            return false;
                         }
                     }
                 } else {
                     return false;
                 }
             }
        }
    }
}