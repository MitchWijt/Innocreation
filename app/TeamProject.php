<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProject extends Model
{
    public $table = "team_project";

    public function getAllLabels(){
        $labelsArray = [];
        $foldersInProject = TeamProjectFolder::select("*")->where("team_project_id", $this->id)->get();
        foreach($foldersInProject as $folder){
            $tasks = TeamProjectTask::select("*")->where("team_project_folder_id", $folder->id)->get();
            foreach($tasks as $task){
                $labels = explode(",", $task->labels);
                foreach($labels as $label){
                    if(strlen($label) > 0) {
                        array_push($labelsArray, $label);
                    }
                }
            }
        }

        return $labelsArray;
    }

    public function getFolders(){
        $foldersInProject = TeamProjectFolder::select("*")->where("team_project_id", $this->id)->get();
        return $foldersInProject;
    }
}
