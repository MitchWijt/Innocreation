<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 04/06/2019
     * Time: 18:17
     */

    namespace App\Services\TeamProject;

    class FixedTitles {
        public static function myTasksFolder(){
            return "My tasks";
        }

        public static function completedFolder(){
            return "Completed";
        }

        public static function requestedForCompletionFolder(){
            return "Validation needed";
        }
    }