<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWorkComment extends Model
{
    public function user(){
        return $this->hasOne("\App\User", "id","sender_user_id");
    }

    public function userWork(){
        return $this->hasOne("\App\UserWork", "id","user_work_id");
    }

    public $table = "user_work_comment";
}
