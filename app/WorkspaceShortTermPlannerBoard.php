<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkspaceShortTermPlannerBoard extends Model
{
    public $table = "workspace_short_term_planner_board";

    public function getUrl(){
        return "/my-team/workspace/short-term-planner/$this->id";
    }
}


