<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamChatGroupLinktable extends Model
{
    public function users(){
        return $this->hasMany("\App\User", "id","user_id");
    }

    public function groupChat(){
        return $this->hasMany("\App\TeamChatGroup", "id","team_chat_group_id");
    }

    public function getGroupChatMessages(){
        return UserMessage::select("*")->where("team_chat_group_id", $this->team_chat_group_id)->get();
    }

    public function getGroupChatMembers(){
        $userIds = [];
        $chats = TeamChatGroupLinktable::select("*")->where("team_chat_group_id" , $this->team_chat_group_id)->get();
        foreach($chats as $chat){
            array_push($userIds, $chat->user_id);
        }
        $users = User::select("*")->whereIn("id", $userIds)->get();
        return $users;
    }
    public $table = "team_chat_group_linktable";
}
