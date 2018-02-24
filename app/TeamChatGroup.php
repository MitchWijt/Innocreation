<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamChatGroup extends Model
{
    public $table = "team_chat_group";

    public function getProfilePicture(){
        return "/images/teamGroupChatProfilePictures/" . $this->profile_picture;
    }
}
