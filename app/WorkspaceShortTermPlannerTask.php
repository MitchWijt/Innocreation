<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceShortTermPlannerTask extends Model
{
    public $table = "workspace_short_term_planner_task";

    public function creator(){
        return $this->hasOne("\App\User", "id","creator_user_id");
    }

    public function board(){
        return $this->hasOne("\App\WorkspaceShortTermPlannerBoard", "id","short_term_planner_board_id");
    }

    public function assignedUser(){
        return $this->hasOne("\App\User", "id","assigned_to");
    }

    public function checkAssistanceTicketRequest(){
        $bool = false;
        $assistanceTickets = AssistanceTicket::select("*")->where("task_id", $this->id)->where("creator_user_id", $this->assigned_to)->where("completed", 0)->get();
        if(count($assistanceTickets) > 0){
            $bool = true;
        }
        return $bool;
    }
}
