<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceShortTermPlannerTask extends Model
{
    public $table = "workspace_short_term_planner_task";

    public function creator(){
        return $this->hasOne("\App\User", "id","creator_user_id");
    }

    public function assignedUser(){
        return $this->hasOne("\App\User", "id","assigned_to");
    }
}
