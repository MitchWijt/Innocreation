<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 25/04/2019
 * Time: 19:01
 */

namespace App\Services\TeamProject;


class TaskEditorService {

    public static function getFontSizes(){
        $sizes = [9, 10, 11, 12, 13, 14, 18, 24, 36, 48, 64, 72];
        return $sizes;
    }

    public static function getFontStyles(){
        $styles = ["Verdana", "Georgia", "Comic Sans", "Trebucket", "Arial black", "Impact", "Helvetica", "Corbert"];
        return $styles;
    }
}