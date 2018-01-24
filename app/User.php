<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public function team(){
        return $this->hasMany("\App\Team", "id","team_id");
    }

    public function getProfilePicture(){
        return "/images/profilePictures/" . $this->profile_picture;
    }

    public function getName(){
        return $this->firstname . " " . $this->lastname;
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
