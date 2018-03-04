<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Team extends Model
{
    public function users(){
        return $this->hasMany("\App\User", "id","ceo_user_id");
    }

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
        // gets the expertise the current team still needs without the accepted members
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
        $NeededExpertisesNoAcception = NeededExpertiseLinktable::select("*")->where("team_id", $this->id)->where("amount", "!=", 0)->whereIn("expertise_id", $expertisesNoAcception)->with("Expertises")->with("Teams")->get();
        return $NeededExpertisesNoAcception;
    }

    public function calculateSupport($stars, $team_id){
        $team = Team::select("*")->where("id", $team_id)->first();
        $support = $team->support;
        if($stars >= 3){
            $positive = true;
        } else {
            $positive = false;
        }

        if($positive){
            if($stars == 3){
                $support = $support + 50;
            } else if($stars == 4){
                $support = $support + 100;
            } else if($stars == 5){
                $support = $support + 200;
            }
        }

        if($positive == false){
            if($stars == 2){
                $support = $support - 20;
            } else if($stars == 1){
                $support = $support - 50;
            }
        }
        return $support;
    }

    public function checkInvite($expertise_id, $team_id, $user_id){
        $bool = false;
        $invite = InviteRequestLinktable::select("*")->where("expertise_id", $expertise_id)->where("team_id", $team_id)->where("user_id", $user_id)->where("accepted", 0)->get();
        if(count($invite) > 0){
            $bool = true;
        }
        return $bool;
    }

}
