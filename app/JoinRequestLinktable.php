<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequestLinktable extends Model
{
    public $table = "join_request_linktable";

    public function expertises(){
        return $this->hasMany("\App\Expertises", "id","expertise_id");
    }

    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }

    public function teams(){
        return $this->hasMany("\App\Team", "id","team_id");
    }
}
