<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 20/04/2019
 * Time: 16:49
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class TeamProjectFolder extends Model {
    public $table = "team_project_folder";

    public function teamProject(){
        return $this->hasOne("\App\TeamProject", "id","team_project_id");
    }

    public function getTasks($userId){
        return TeamProjectTask::select("*")->where("team_project_folder_id", $this->id)->where("assigned_user_id", "!=", $userId)->where("type", 1)->orWhere("assigned_user_id", null)->where("team_project_folder_id", $this->id)->where("type", 1)->get();
    }

    public function getPrivateTasks($userId){
        return TeamProjectTask::select("*")->where("team_project_folder_id", $this->id)->where("created_user_id", $userId)->where("type", 2)->get();
    }

    public function getAllTasks($userId){
        $array = [];
        $allNormalTasks = $this->getTasks($userId);
        foreach($allNormalTasks as $normalTask){
            array_push($array, $normalTask);
        }

        $privateTasks = $this->getPrivateTasks($userId);
        foreach ($privateTasks as $privateTask){
            array_push($array, $privateTask);
        }

        return $array;
    }


}