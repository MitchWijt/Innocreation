<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWork extends Model
{

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function getUrl(){
        return "https://" . $_SERVER["HTTP_HOST"] . "/innocreatives/$this->id";
    }

    public function getImage(){
        $userslug = $this->user->slug;
        return "https://space-innocreation.ams3.cdn.digitaloceanspaces.com/users/$userslug/userworks/$this->id/$this->content";
    }

    public function getComments(){
        return UserWorkComment::select("*")->where("user_work_id", $this->id)->orderBy("created_at")->get();
    }

    public function getPopoverMenu(){
        $userWork = $this;
        return view("/public/userworkFeed/shared/_popoverMenu", compact("userWork"));

    }
    public $table = "user_work";

}
