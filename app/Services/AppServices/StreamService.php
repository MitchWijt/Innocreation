<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 10/01/2019
 * Time: 21:37
 */

namespace App\Services\AppServices;


use GetStream\Stream\Client;

class StreamService
{

    public $client;

    public function __construct() {
        $client = new Client(env("STREAM_API"), env("STREAM_SECRET"));
        $this->client = $client;
    }

    public function getStreamFeed($userId){
        return $this->client->feed("user", $userId);
    }

    public function addActivityToFeed($userId, $data){
        $feed = self::getStreamFeed($userId);
        $feed->addActivity($data);
    }
}