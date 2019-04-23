<?php
/**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 19/04/2019
     * Time: 12:49
     */

namespace App\Services;


class CustomIconService {
    public static function getIcon($iconName, $height = "25px"){
        switch($iconName){
            case "file-outline":
                return self::fileOutlineIcon($height);
                break;
            case "tag-outline":
                return self::tagOutlineIcon($height);
                break;
            case "checkbox-list":
                return self::checkBoxListIcon($height);
                break;
        }
    }

    private static function fileOutlineIcon($height = "25px"){
        // file outline icon
        return "<svg style=\"height: $height\" viewBox=\"0 2 24 24\"> <path fill=\"#000000\" d=\"M6,2A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2H6M6,4H13V9H18V20H6V4M8,12V14H16V12H8M8,16V18H13V16H8Z\" /></svg>";
    }

    private static function tagOutlineIcon($height = "25px"){
        return "<svg height=\"$height\" viewBox=\"0 0 394 394.00086\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"m122.5625 380.644531c17.8125 17.808594 46.6875 17.808594 64.5 0l204.886719-204.886719c1.320312-1.320312 2.058593-3.117187 2.050781-4.984374l-.820312-162.984376c-.019532-3.839843-3.128907-6.945312-6.964844-6.964843l-162.988282-.824219c-1.871093-.0273438-3.671874.714844-4.984374 2.050781l-204.882813 204.886719c-17.8125 17.808594-17.8125 46.6875 0 64.5zm-99.300781-163.808593 202.820312-202.820313 153.136719.773437.769531 153.132813-202.816406 202.820313c-12.347656 12.34375-32.359375 12.34375-44.703125 0l-109.199219-109.199219c-12.339843-12.34375-12.339843-32.355469 0-44.699219zm0 0\"/><path d=\"m278.6875 160.902344c21.746094-.015625 40.457031-15.390625 44.6875-36.722656 4.230469-21.332032-7.199219-42.683594-27.296875-50.996094s-43.265625-1.269532-55.339844 16.820312-9.6875 42.1875 5.695313 57.558594c8.550781 8.558594 20.15625 13.359375 32.253906 13.339844zm-22.351562-67.941406c12.34375-12.34375 32.355468-12.34375 44.703124 0 12.34375 12.34375 12.34375 32.355468 0 44.699218-12.347656 12.347656-32.359374 12.34375-44.703124 0-5.953126-5.914062-9.296876-13.957031-9.296876-22.347656s3.34375-16.433594 9.296876-22.347656zm0 0\"/></svg>";
    }

    private static function checkBoxListIcon($height = "25px"){
        return "<?xml version=\"1.0\" ?><svg enable-background=\"new 0 0 512 512\" height=\"$height\" id=\"Layer_1\" version=\"1.1\" viewBox=\"0 0 512 512\" xml:space=\"preserve\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"><g><rect fill=\"none\" height=\"61.5\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" width=\"61.5\" x=\"124.8\" y=\"134.7\"/><line fill=\"none\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" x1=\"210.3\" x2=\"387.2\" y1=\"165.4\" y2=\"165.4\"/><rect fill=\"none\" height=\"61.5\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" width=\"61.5\" x=\"124.8\" y=\"225.3\"/><line fill=\"none\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" x1=\"210.3\" x2=\"387.2\" y1=\"256\" y2=\"256\"/><rect fill=\"none\" height=\"61.5\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" width=\"61.5\" x=\"124.8\" y=\"315.8\"/><line fill=\"none\" stroke=\"#000000\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-miterlimit=\"10\" stroke-width=\"10\" x1=\"210.3\" x2=\"387.2\" y1=\"346.6\" y2=\"346.6\"/></g></svg>";
    }
}