<?php
/**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 16/06/2019
     * Time: 11:50
     */

namespace App\Services\TeamProject;

use App\TeamProjectTask;
use App\TeamProjectTaskValidation;
use App\User;
use Illuminate\Support\Facades\Session;

class TeamProjectTaskService {
    public static function getTasks($folderId){
        $tasks = TeamProjectTask::select("*")->where("team_project_folder_id", $folderId)->where("assigned_user_id", null)->get();
        return $tasks;
    }

    public function disableCompleteNotification($request){
        $userId = $request->input("userId");

        $user = User::select("*")->where("id", $userId)->first();
        $user->notification_task_completed = $request->input("value");
        $user->save();
        return "TRUE";
    }
}