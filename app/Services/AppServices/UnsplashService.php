<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 28/10/2018
 * Time: 11:23
 */

namespace App\Services\AppServices;


use Crew\Unsplash\HttpClient;
use Crew\Unsplash\Photo;
use Crew\Unsplash\Search;
use function GuzzleHttp\json_encode;

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
        $singleImage = $images[array_rand($images)];
        return json_encode(["id" => $singleImage['id'],"image" => $singleImage['urls']['regular'], "photographer" => array("name" => $singleImage["user"]['name'], 'url' => $singleImage["user"]['links']['html']), "image_link" => $singleImage['links']['html']]);
    }

    public function getListOfImages($keyword){
        $page = 1;
        $per_page = 25;
        $orientation = 'landscape';

        $search = Search::photos($keyword, $page, $per_page, $orientation);
        $array = [];
        $counter = 0;
        $images = $search->getResults();
        foreach($images as $image){
            if($counter < 4) {
                $img = $images[array_rand($images)];
                array_push($array, $img);
            }
            $counter++;
        }
        return json_encode($array);

    }

    public function downloadPhoto($id){
       $photo = Photo::find($id);
       $photo->download();
    }
}