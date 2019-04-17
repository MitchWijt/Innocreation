<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProjectLinktable extends Model
{
    public $table = "team_project_linktable";

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function teamProject(){
        return $this->hasMany("\App\TeamProject", "id","team_project_id");
    }
}
