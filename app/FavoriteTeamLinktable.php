<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteTeamLinktable extends Model
{
    public $table = "favorite_teams_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
