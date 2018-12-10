<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 05/12/2018
 * Time: 17:46
 */

namespace App\Services;

use App\ConnectRequestLinktable;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserWork;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Session;
class GenericService
{
    public static function dateDiffToString($interval){
        $years = $interval->y;
        $months = $interval->m;
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        if($seconds != 0 && $minutes == 0 && $hours == 0 && $days == 0 && $months == 0 && $years == 0){
            $string = sprintf('%d seconds ago', $seconds);
        } else if($minutes != 0 && $hours == 0 && $days == 0 && $months == 0 && $years == 0){
            $string = sprintf('%d minutes ago', $minutes);
        } else if(($minutes != 0 || $hours != 0) && $days == 0 && $months == 0 && $years == 0) {
            $string = sprintf('%d hours and %d minutes ago', $hours, $minutes);
        } else if($days != 0 && $months == 0 && $years == 0) {
            $string = sprintf('%d days ago', $days);
        } else if($months != 0 && $years == 0){
            $string = sprintf('%d months ago', $months);
        } else if($years != 0){
            $string = sprintf('%d year ago', $years);
        }

        return $string;
    }
}