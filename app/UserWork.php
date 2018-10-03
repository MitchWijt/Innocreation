<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function getImage(){
        $userslug = $this->user->slug;
        return "https://space-innocreation.ams3.cdn.digitaloceanspaces.com/users/$userslug/userworks/$this->id/$this->content";
    }

    public function getComments(){
        return UserWorkComment::select("*")->where("user_work_id", $this->id)->orderBy("created_at")->get();
    }
    public $table = "user_work";

}
