<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamGroupChat extends Model
{
    public $table = "team_group_chat";

    public function getTeam(){
        return TeamGroupChatLinktable::select("*")->where("team_group_chat_id", $this->id)->first()->team;
    }

    public function getProfilePicture(){
         return "https://space-innocreation.ams3.cdn.digitaloceanspaces.com/teams/" . $this->getTeam()->slug ."/groupchats/" .strtolower(str_replace(" ", "-", $this->title)) ."/$this->profile_picture";
    }
}
