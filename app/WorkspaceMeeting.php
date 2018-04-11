<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMeeting extends Model
{
    public $table = "workspace_meeting";

    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }
}
