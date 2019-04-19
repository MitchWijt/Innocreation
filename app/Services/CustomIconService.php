<?php
/**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 19/04/2019
     * Time: 12:49
     */

namespace App\Services;


class CustomIconService {
    public static function getIcon($iconName){
        switch($iconName){
            case "file-outline":
                return self::fileOutlineIcon();
                break;
        }
    }

    private static function fileOutlineIcon(){
        // file outline icon
        return "<svg style=\"height:25px\" viewBox=\"0 2 24 24\"> <path fill=\"#000000\" d=\"M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4M8,12V14H16V12H8M8,16V18H13V16H8Z\" /></svg>";
    }
}