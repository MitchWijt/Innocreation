<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 06/02/2019
     * Time: 18:46
     */

    namespace App\Services\FeedServices;

    use App\Emoji;
    use App\Expertises;
    use App\Services\Images\ImageProcessor;
    use App\Services\Paths\PublicPaths;
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
                    $userWorkPosts = UserWork::select("*")->whereNotIn("id", $request->input("userworkArray"))->where('approved', 1)->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                } else if($page == "admin"){
                    $userWorkPosts = UserWork::select("*")->whereNotIn("id", $request->input("userworkArray"))->where('approved', 0)->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                } else {
                    $userId = $request->input("userId");
                    $userWorkPosts = UserWork::select("*")->whereNotIn("id", $request->input("userworkArray"))->where("user_id", $userId)->orderBy("created_at", "DESC")->limit(self::POSTS_LIMIT)->get();
                }

                return $userWorkPosts;
            } else {
                if($page == "feedPage"){
                    $userWorkPosts = UserWork::select("*")->orderBy("created_at", "DESC")->where('approved', 1)->limit(self::POSTS_LIMIT)->get();
                } else if($page == "admin"){
                    $userWorkPosts = UserWork::select("*")->orderBy("created_at", "DESC")->where('approved', 0)->limit(self::POSTS_LIMIT)->get();
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

        public function requestPostUserWork($request, $streamService){
            $userId = $request->input("user_id");
            $file = $request->file('file');
            $description = htmlspecialchars($request->input("description"));
            $relatedExpertisesArray = explode(",", $request->input("relatedExpertises"));

            $expertises = Expertises::select("*")->whereIn("title", $relatedExpertisesArray)->get();
            $expertiseIds = "";
            foreach($expertises as $expertise){
                if($expertiseIds == ""){
                    $expertiseIds = $expertise->id;
                } else {
                    $expertiseIds = $expertiseIds . "," . $expertise->id;
                }
            }

            $userWork = new UserWork();
            $userWork->description = $description;
            $userWork->user_id = $userId;
            $userWork->related_expertises_ids = $expertiseIds;
            $userWork->approved = 0;
            $userWork->save();

            if($file) {
                if($file->getClientOriginalExtension() !== "jpeg" && $file->getClientOriginalExtension() !== "jpg") {
                    return 01;
                }
                $size = ImageProcessor::formatBytes($file->getSize());
                if ($size < 8) {
                    $imageProcessor = new ImageProcessor();
                    $user = User::select("*")->where("id", $userId)->first();
                    $uniqueId = uniqid($userWork->id);

                    //Creates and uploads Original image
                    $filename = PublicPaths::getFileName($uniqueId, $file);
                    $path = PublicPaths::getUserWorkDir($user, $userWork, $filename);
                    $imageProcessor->upload(null,$path, false, $file->getRealPath());

                    //Creates and uploads placeholder of Original image
                    $filenamePlaceholder = PublicPaths::getFileName($uniqueId, $file, true);
                    $path = PublicPaths::getUserWorkDir($user, $userWork, $filenamePlaceholder);
                    $imageProcessor->createPlaceholder($file, $file->getRealPath(), $path);

                    //Saves new userwork feed post with image. Filename and extension seperate
                    $filenameWithoutExtension = PublicPaths::getFileName($uniqueId, $file, false, false);
                    $userWork->content = $filenameWithoutExtension;
                    $userWork->extension = $file->getClientOriginalExtension();
                    $userWork->created_at = date("Y-m-d H:i:s");
                    $userWork->save();

                    return 1;
                } else {
                    $userWork->delete();
                    return 02;
                }
            } else {
                return 03;
            }
        }
    }