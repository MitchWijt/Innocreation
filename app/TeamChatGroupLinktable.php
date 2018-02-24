<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamChatGroupLinktable extends Model
{
    public function users(){
        return $this->hasMany("\App\User", "id","ceo_user_id");
    }

    public function groupChat(){
        return $this->hasMany("\App\TeamChatGroup", "id","team_chat_group_id");
    }

    public function getGroupChatMessages(){
        return UserMessage::select("*")->where("team_chat_group_id", $this->team_chat_group_id)->get();
    }
    public $table = "team_chat_group_linktable";
}
