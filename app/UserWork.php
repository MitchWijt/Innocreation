<?php

namespace App;

use App\Services\UserConnections\ConnectionService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserWork extends Model
{

    public $table = "user_work";

    public function user(){
        return $this->hasOne("\App\User", "id","user_id");
    }

    public function getUrl(){
        return "https://" . $_SERVER["HTTP_HOST"] . "/innocreatives/$this->id";
    }

    public function getImage(){
        $userslug = $this->user->slug;
        return sprintf('https://space-innocreation.ams3.cdn.digitaloceanspaces.com/users/%s/userworks/%d/%s', $userslug, $this->id, $this->content);
    }

    public function getComments(){
        return UserWorkComment::select("*")->where("user_work_id", $this->id)->orderBy("created_at")->get();
    }

    public function getPopoverMenu(){
        $userWork = $this;
        return view("/public/userworkFeed/shared/_popoverMenu", compact("userWork"));

    }


}
