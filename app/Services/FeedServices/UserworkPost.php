<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 29/01/2019
     * Time: 18:26
     */

    namespace App\Services\FeedServices;
    use App\UserWork;

    class UserworkPost {
        public function getPostModal($request){
            $userWorkId = $request->input("userworkId");
            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            return view("public/userworkFeed/shared/_userworkPostModal", compact("userWork"));
        }
    }