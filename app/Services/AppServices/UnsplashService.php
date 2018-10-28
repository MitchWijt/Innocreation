<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 28/10/2018
 * Time: 11:23
 */

namespace App\Services\AppServices;


use Crew\Unsplash\HttpClient;
use Crew\Unsplash\Search;

class UnsplashService
{
    public function __construct() {
        HttpClient::init([
            'applicationId' => env("UN_ACCESS"),
            'secret' => env("UN_SECRET"),
            'utmSource' => env("UN_UTM")
        ]);
    }

    public function searchAndGetImageByKeyword($keyword){
        $page = 1;
        $per_page = 10;
        $orientation = 'landscape';

        $search = Search::photos($keyword, $page, $per_page, $orientation);
        $images = $search->getResults();
        return json_encode(["image" => $images[array_rand($images)]['urls']['regular'], "photographer" => array("name" => $images[array_rand($images)]["user"]['name'], 'url' => $images[array_rand($images)]["user"]['links']['html'])]);
    }
}