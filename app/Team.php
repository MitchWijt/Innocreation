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
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->with("Expertises")->with("Teams")->get();
        return $neededExpertises;
    }

    public function getNeededExpertisesWithoutAcception(){
        // gets the expertise the current team still needs without the accpedted members
        $expertisesNoAcception = [];
        $acceptedExpertises = [];
        $expertises = JoinRequestLinktable::select("*")->where("team_id",$this->id)->where("accepted", 1)->get();
        foreach($expertises as $expertise){
            array_push($acceptedExpertises, $expertise->expertise_id);
        }
        $neededExpertises  = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->get();
        foreach($neededExpertises as $neededExpertise){
            if(!in_array($neededExpertise->expertise_id, $acceptedExpertises)){
                array_push($expertisesNoAcception, $neededExpertise->expertise_id);
            }
        }
        $NeededExpertisesNoAcception = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->whereIn("expertise_id", $expertisesNoAcception)->with("Expertises")->with("Teams")->get();
        return $NeededExpertisesNoAcception;
    }
}
