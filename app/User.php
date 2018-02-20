<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function roles(){
        return $this->hasMany("\App\UserRole", "id","role");
    }

    public function getProfilePicture(){
        return "/images/profilePicturesUsers/" . $this->profile_picture;
    }

    public function getName(){
        if($this->middlename != null){
            return $this->firstname . " " . $this->middlename . " " . $this->lastname;
        } else {
            return $this->firstname . " " . $this->lastname;
        }

    }

    public function getUrl(){
        if($this->middlename != null){
            return "/user/". $this->firstname . "-" . $this->middlename . "-" . $this->lastname;
        } else {
            return "/user/". $this->firstname . "-" . $this->lastname;
        }

    }

    public function getExpertises(){
        $expertiseArray = [];
        $expertiseLinktable = expertises_linktable::select("*")->where("user_id", $this->id)->with("Expertises")->get();
        foreach($expertiseLinktable as $expertise){
            array_push($expertiseArray, $expertise->expertise_id);
        }
        $expertises = Expertises::select("*")->whereIn("id", $expertiseArray)->get();
        return $expertises;
    }

    public function getJoinedExpertise(){
        $expertise = JoinRequestLinktable::select("*")->where("user_id", $this->id)->where("accepted", 1)->first();
        return $expertise;
    }

    public function checkJoinRequests($expertise_id, $team_id){
        $bool = false;
        $joinRequests = JoinRequestLinktable::select("*")->where("expertise_id", $expertise_id)->where("team_id", $team_id)->where("user_id", $this->id)->where("accepted", 0)->get();
        if(count($joinRequests) > 0){
            $bool = true;
        }
        return $bool;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
