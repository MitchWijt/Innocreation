<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceIdeas extends Model
{
    public $table = "workspace_ideas";

    public function users(){
        return $this->hasMany("\App\User", "id","creator_user_id");
    }

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
