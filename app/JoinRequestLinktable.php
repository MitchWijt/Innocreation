<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequestLinktable extends Model
{
    public $table = "join_request_linktable";

    public function expertises(){
        return $this->hasMany("\App\Expertises", "id","expertise_id");
    }

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
