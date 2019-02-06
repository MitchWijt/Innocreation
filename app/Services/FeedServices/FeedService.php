<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 06/02/2019
     * Time: 18:46
     */

    namespace App\Services\FeedServices;

    use App\Emoji;
    use App\User;
    use App\UserWork;
    use Illuminate\Support\Facades\Session;

    class FeedService {
        const POSTS_LIMIT = 15;

        public function getUserworkPosts($request, $more = false){
            return self::returnPosts($request, $more);
        }

        public function getMoreUserworkPosts($request, $more = true){
            return self::returnPosts($request, $more);
        }

        public static function getPosts($page, $request, $more = false){
            if($more){
                if($page == "feedPage"){
                    $userWorkPosts = UserWork::select("*")->whereNotIn("id", $request->input("userworkArray"))->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                } else {
                    $userId = $request->input("userId");
                    $userWorkPosts = UserWork::select("*")->whereNotIn("id", $request->input("userworkArray"))->where("user_id", $userId)->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                }

                return $userWorkPosts;
            } else {
                if($page == "feedPage"){
                    $userWorkPosts = UserWork::select("*")->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                } else {
                    $userId = $request->input("userId");
                    $userWorkPosts = UserWork::select("*")->where("user_id", $userId)->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                }

                return $userWorkPosts;
            }
        }

        public static function returnPosts($request, $more){
            $emojis = Emoji::select("*")->get();
            if($more){
                $userWorkPosts = self::getPosts($request->input("page"), $request, true);
            } else {
                $userWorkPosts = self::getPosts($request->input("page"), $request);
            }

            if(Session::has("user_id")) {
                $user = User::select("*")->where("id", Session::get("user_id"))->first();
                return view("/public/userworkFeed/shared/_userworkPosts", compact("user", "userWorkPosts", "emojis"));
            }
            return view("/public/userworkFeed/shared/_userworkPosts", compact("userWorkPosts", "emojis"));
        }
    }