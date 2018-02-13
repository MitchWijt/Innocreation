<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteTeamLinktable extends Model
{
    public $table = "favorite_teams_linktable";

    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }

    public function teams(){
        return $this->hasMany("\App\Team", "id","team_id");
    }
}
