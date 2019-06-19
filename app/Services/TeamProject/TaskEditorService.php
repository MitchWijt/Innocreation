<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 25/04/2019
 * Time: 19:01
 */

namespace App\Services\TeamProject;


use App\TeamProjectTask;
use Illuminate\Support\Facades\Session;

class TaskEditorService {

    public static function getFontSizes(){
        $sizes = [9, 10, 11, 12, 13, 14, 18, 24, 36, 48, 64, 72];
        return $sizes;
    }

    public static function getFontStyles(){
        $styles = ["Verdana", "Georgia", "Comic Sans", "Trebucket", "Arial black", "Impact", "Helvetica", "Corbert-Regular"];
        return $styles;
    }

    public static function getTaskContextmenuOptions($task){
        if($task->created_user_id == Session::get("user_id")) {
            if ($task->type == 2) {
                $array = [['title' => "Set to public", "action" => "form", "formUrl" => "/teamProject/setTaskPublic"], ['title' => "Copy link", "action" => "copy"]];
            } else if ($task->type == 1) {
                $array = [['title' => "Set to private", "action" => "form", "formUrl" => "/teamProject/setTaskPrivate"], ['title' => "Copy link", "action" => "copy"]];
            } else {
                $array = [['title' => "Set to private", "action" => "form", "formUrl" => "/teamProject/setTaskPrivate"], ['title' => "Set to public", "action" => "form", "formUrl" => "/teamProject/setTaskPublic"], ['title' => "Copy link", "action" => "copy"]];
            }
        } else {
            $array = [
                ['title' => "Copy link", "action" => "copy"]
            ];
        }


        return $array;
    }

    public static function isDisabled($taskId){

        $bool = false;
        $task = TeamProjectTask::select("*")->where("id", $taskId)->first();

        // task in completed stage
        if($task->completed == 1){
            $bool = true;
        }

        // task in changes needed stage
        if($task->changes_needed == 1){
            $bool = true;
        }

        // task in validation stage
        if($task->validation_needed == 1){
            $bool = true;
        }

        // task folder in my tasks
        if($task->folder->title == FixedTitles::myTasksFolder()){
            $bool = true;
        }

        return $bool;
    }
}