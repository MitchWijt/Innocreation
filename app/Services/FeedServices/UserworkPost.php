<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 29/01/2019
     * Time: 18:26
     */

    namespace App\Services\FeedServices;
    use App\Emoji;
    use App\Services\TimeSent;
    use App\User;
    use App\UserWork;
    use App\UserWorkComment;
    use Illuminate\Support\Facades\Session;

    class UserworkPost {
        public function getPostModal($request){
            $userWorkId = $request->input("userworkId");
            $userWorkPost = UserWork::select("*")->where("id", $userWorkId)->first();
            $emojis = Emoji::select("*")->get();

            if(Session::has("user_id")) {
                $user = User::select("*")->where("id", Session::get("user_id"))->first();
                return view("public/userworkFeed/shared/_userworkPostModal", compact("userWorkPost", "emojis", "user"));
            }

            return view("public/userworkFeed/shared/_userworkPostModal", compact("userWorkPost", "emojis"));

        }

        public static function getRecentComments($id){
            $comments = UserWorkComment::select("*")->where("user_work_id", $id)->limit(2)->orderBy("created_at", "desc")->get();
            return $comments;
        }

        public function postComment($request){
            $senderUserId = $request->input("sender_user_id");
            $user_work_id = $request->input("user_work_id");
            $comment = $request->input("comment");
            $timeSent = new TimeSent();

            $userWorkComment = new UserWorkComment();
            $userWorkComment->sender_user_id = $senderUserId;
            $userWorkComment->user_work_id = $user_work_id;
            $userWorkComment->time_sent = $timeSent->time;
            $userWorkComment->message = $comment;
            $userWorkComment->created_at = date("Y-m-d H:i:s");
            $userWorkComment->save();


            $messageArray = ["message" => $comment, "timeSent" => $timeSent->time];
            echo json_encode($messageArray);
            die();
        }

        public function postNewUserWorkPost(){

        }
    }