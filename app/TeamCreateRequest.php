<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamCreateRequest extends Model
{
    public function sender(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }

    public function receiver(){
        return $this->hasOne("\App\User", "id","receiver_user_id");
    }
    public $table = "team_create_request";

}
