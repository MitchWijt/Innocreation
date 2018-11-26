<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/11/2018
 * Time: 20:49
 */
namespace App\Services\Home;
use App\Expertises;

class HomeService
{
    public function searchExpertise($request){
        $title = $request->input("title");
        $expertise = Expertises::select("*")->where("title", $title)->first();
        return sprintf('/%s/users', $expertise->slug);
    }
}