<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollowLinktable extends Model
{
    public $table = "user_follow_linktable";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function followedUser(){
        return $this->hasOne("\App\User", "id","followed_user_id");
    }
}
