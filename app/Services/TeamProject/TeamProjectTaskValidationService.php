<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 16/06/2019
 * Time: 16:10
 */

namespace App\Services\TeamProject;


use App\TeamProjectTaskValidation;
use Illuminate\Support\Facades\Session;

class TeamProjectTaskValidationService {
    public static function getPercentagePassed($taskId){
        $passed = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->where("type_review",1)->count();
        $allReviewsFromTask = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->count();

        if($allReviewsFromTask == 0 ){
            return 0 . "%";
        }

        $percentage = ($passed / $allReviewsFromTask) * 100;

        return number_format($percentage, 0, ",", "."). "%";
    }

    public static function getPercentageImprove($taskId){
        $improvement = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->where("type_review",2)->count();
        $allReviewsFromTask = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->count();

        if($allReviewsFromTask == 0 ){
            return 0 . "%";
        }

        $percentage = ($improvement / $allReviewsFromTask) * 100;

        return number_format($percentage, 0, ",", "."). "%";
    }

    public static function getRespondedReviewPercentage($allMembers, $taskId){
        $allReviewsFromTask = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->count();
        $percentage = ($allReviewsFromTask / $allMembers) * 100;

        return number_format($percentage, 0, ",", ".") . "%";

    }

    public static function hasReviewed($taskId){
        $reviewedTask = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->where("user_id", Session::get("user_id"))->count();
        if($reviewedTask != 0){
            return true;
        } else {
            return false;
        }

    }

    public static function getSingleReview($taskId){
        $reviewedTask = TeamProjectTaskValidation::select("*")->where("team_project_task_id", $taskId)->where("user_id", Session::get("user_id"))->first();
        return $reviewedTask;
    }
}