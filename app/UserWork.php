<?php

namespace App;

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

    public function getPopoverSwitchView(){
        $userWork = $this;

        if(!Session::has("user_id")){
            return view("/public/userworkFeed/shared/_popoverSwitch", compact("userWork"));
        }

        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        return view("/public/userworkFeed/shared/_popoverSwitch", compact("userWork", "user"));

    }

    public function hasSwitched(){
        $connectRequest = ConnectRequestLinktable::select("*")->where("receiver_user_id", $this->user_id)->where("sender_user_id", Session::get("user_id"))->first();
        if(count($connectRequest) > 0){
            return true;
        } else {
            return false;
        }
    }


}
