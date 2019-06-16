<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 16/06/2019
 * Time: 11:03
 */
namespace App\Services\TeamProject;

class TypeOfTaskReview {
    const IMPROVEMENT_NEEEDED = 2;
    const CRITERIA_PASSED = 1;

    public static function getTitle($type){
        if($type == 2){
            return "Improvement needed";
        } else {
            return "Passed all criteria";
        }
    }
}