<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Expertises_linktable;

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

    public function getTop3ActiveUsers(){
        $expertiseLinktable = expertises_linktable::select("*")->where("expertise_id", $this->id)->limit(3)->get();
        return $expertiseLinktable;
    }

    public function getTags(){
        $tagsExplode = explode(",", $this->tags);
        $temp = "";
        foreach($tagsExplode as $item){
            if($temp == ""){
                $temp = trim($item);
            } else {
                $temp = $temp . ",  " . trim($item);
            }
        }

        return $temp;
    }
}
