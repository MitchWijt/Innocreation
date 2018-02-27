<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamGroupChat extends Model
{
    public $table = "team_group_chat";

    public function getProfilePicture(){
        return "/images/teamGroupChatProfilePictures/" . $this->profile_picture;
    }
}
