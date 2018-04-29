<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expertises extends Model
{
    public function getActiveUsers(){
        $usersArray = [];
        $expertiseLinktable = expertises_linktable::select("*")->where("expertise_id", $this->id)->get();
        foreach($expertiseLinktable as $expertise){
            array_push($usersArray, $expertise->user_id);
        }
        $users = User::select("*")->whereIn("id", $usersArray)->get();
        return $users;
    }
}
