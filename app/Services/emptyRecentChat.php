<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/01/2019
 * Time: 21:36
 */

namespace App\Services;


class emptyRecentChat
{
    public $message;
    public $time_sent;
    public $seen_at;
    public $sender_user_id;

    public function __construct($sender_user_id) {
        $this->message = "";
        $this->time_sent = "";
        $this->seen_at = "";
        $this->sender_user_id = $sender_user_id;
    }
}