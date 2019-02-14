<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 12/01/2019
 * Time: 22:20
 */

namespace App\Services;


class TimeSent
{
    public $time;

    public function __construct() {
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        $this->time = $time;
        return $this->time;
    }
}