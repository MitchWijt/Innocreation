<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamGroupChatLinktable extends Model
{
    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function groupChat(){
        return $this->hasMany("\App\TeamGroupChat", "id","team_group_chat_id");
    }

    public function getGroupChatMessages(){
        return UserMessage::select("*")->where("team_group_chat_id", $this->team_group_chat_id)->get();
    }

    public function getGroupChatMembers(){
        $userIds = [];
        $chats = TeamGroupChatLinktable::select("*")->where("team_group_chat_id" , $this->team_group_chat_id)->get();
        foreach($chats as $chat){
            array_push($userIds, $chat->user_id);
        }
        $users = User::select("*")->whereIn("id", $userIds)->get();
        return $users;
    }
    public $table = "team_group_chat_linktable";
}
