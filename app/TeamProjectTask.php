<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 20/04/2019
 * Time: 16:46
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class TeamProjectTask extends Model {

    public $table = "team_project_task";

    public function folder(){
        return $this->hasOne("\App\TeamProjectFolder", "id","team_project_folder_id");
    }

    public function assignedUser(){
        return $this->hasOne("\App\User", "id","assigned_user_id");
    }

//    public function requestCompletion(){
//        return $this->hasOne("\App\User", "id","assigned_user_id");
//    }
}