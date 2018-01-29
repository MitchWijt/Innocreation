<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        $today = date("Y-m-d");
        $date = date("Y-m-d",strtotime($this->created_at));
        $age = strtotime($date) - strtotime($today);
        return date("m-d", strtotime($age));
    }
}
