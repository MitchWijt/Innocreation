<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Team extends Model
{
    public function getProfilePicture(){
        return "/images/profilePictures/" . $this->team_profile_picture;
    }

    public function getMembers(){
        $users = User::select("*")->where("team_id", $this->id)->get();
        return $users;
    }

    public function calculateAge(){
        $today = new DateTime(date("Y-m-d"));
        $date = new DateTime(date("Y-m-d",strtotime($this->created_at)));
        $interval = $date->diff($today);
        return $interval->format('%m months, %d days');
    }
}
