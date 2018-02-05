<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Team extends Model
{
    public function getProfilePicture(){
        return "/images/profilePicturesTeams/" . $this->team_profile_picture;
    }

    public function getMembers(){
        // gets all the members in the current team
        $users = User::select("*")->where("team_id", $this->id)->get();
        return $users;
    }

    public function calculateAge(){
        // returns the age of the team on date of creation
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d",strtotime($this->created_at)));
        $interval = $date->diff($today);
        return $interval->format('%m months, %d days');
    }

    public function getNeededExpertises(){
        // gets the expertise the current team still needs

//        $neededExpertiseArray = [];
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->with("Expertises")->with("Teams")->get();
//        foreach($neededExpertises as $neededExpertise){
//            array_push($neededExpertiseArray, $neededExpertise->expertise_id);
//        }
//        $expertises = Expertises::select("*")->whereIn("id", $neededExpertiseArray)->get();
        return $neededExpertises;
    }
}
