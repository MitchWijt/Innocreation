<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssistanceTicket extends Model
{
    public $table = "assistance_ticket";

    public function task(){
        return $this->hasMany("\App\WorkspaceShortTermPlannerTask", "id","task_id");
    }
}
