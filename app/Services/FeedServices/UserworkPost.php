<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 29/01/2019
     * Time: 18:26
     */

    namespace App\Services\FeedServices;
    use App\Emoji;
    use App\Expertises;
    use App\Services\Frontend\ExpertiseSphere;
    use App\Services\Images\ImageProcessor;
    use App\Services\Paths\PublicPaths;
    use App\Services\TimeSent;
    use App\Services\UserAccount\UserAccount;
    use App\User;
    use App\UserFollowLinktable;
    use App\UserWork;
    use App\UserWorkComment;
    use App\UserWorkInterestsLinktable;
    use function GuzzleHttp\json_encode;
    use Illuminate\Support\Facades\Session;
    use Illuminate\View\View;

    class UserworkPost {
        private static function generateHash($id){
            return base64_encode($id);
        }

        public function unhashId($request){
            $hash = $request->input("hash");
            $id = base64_decode($hash);
            return $id;
        }

        public function encrypt_decrypt($action, $input){
            $output = false;

            $encrypt_method = "AES-256-CBC";
            $secret_key = 'This is my secret key';
            $secret_iv = 'This is my secret iv';

            // hash
            $key = hash('sha256', $secret_key);

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $secret_iv), 0, 16);

            if( $action == 'encrypt' ) {
                $output = openssl_encrypt($input, $encrypt_method, $key, 0, $iv);
                $output = base64_encode($output);
            }
            else if( $action == 'decrypt' ){
                $output = openssl_decrypt(base64_decode($input), $encrypt_method, $key, 0, $iv);
            }

            return $output;
        }

        public function getPostModal($request){
            $userWorkId = $request->input("userworkId");
            $hash = $this->encrypt_decrypt("encrypt", $userWorkId);
            $userWorkPost = UserWork::select("*")->where("id", $userWorkId)->first();
            $emojis = Emoji::select("*")->get();
            if(Session::has("user_id")) {
                $user = User::select("*")->where("id", Session::get("user_id"))->first();
                $view = view("public/userworkFeed/shared/_userworkPostModal", compact("userWorkPost", "emojis", "user"));
                $contents = $view->render();
                return json_encode(["view" => $contents, 'hash' => $hash]);
            }
            $view = view("public/userworkFeed/shared/_userworkPostModal", compact("userWorkPost", "emojis"));
            $contents = $view->render();
            return json_encode(["view" => $contents, 'hash' => $hash]);
        }

        public static function getRecentComments($id){
            $comments = UserWorkComment::select("*")->where("user_work_id", $id)->limit(2)->orderBy("created_at", "desc")->get();
            return $comments;
        }

        public function postComment($request, $streamService){
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


            $notificationMessage = sprintf("A comment has been placed on your feed post by %s!", $userWorkComment->user->firstname);
            $timeSent = new TimeSent();
            $data = ["actor" => $userWorkComment->userWork->user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3", "link" => "innocreatives/" . self::encrypt_decrypt("encrypt", $user_work_id)];
            $streamService->addActivityToFeed($userWorkComment->userWork->user_id, $data);


            $messageArray = ["message" => $comment, "timeSent" => $timeSent->time];
            echo json_encode($messageArray);
            die();
        }

        public function interestModal($request){
            $loggedIn = UserAccount::isLoggedIn();
            $userWork = UserWork::select("*")->where("id", $request->input("userWorkId"))->first();

            $users = [];
            $interests = $userWork->getInterests();
            foreach($interests as $interest){
                array_push($users, $interest->user);
            }

            return view("/public/userworkFeed/shared/_interestModal", compact("users", "loggedIn"));
        }

        public static function getRelatedExpertises($userWorkId){
            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            $expertisesIds = explode(",", $userWork->related_expertises_ids);

            $expertises = Expertises::select("*")->whereIn("id", $expertisesIds)->get();

            return $expertises;
        }

        public function interestPost($request, $streamService){
            $userWorkId = $request->input("user_work_id");
            $interest = new UserWorkInterestsLinktable();
            $interest->user_id = Session::get("user_id");
            $interest->user_work_id = $userWorkId;
            $interest->created_at = date("Y-m-d H:i:s");
            $interest->save();


            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();

            $hash = self::encrypt_decrypt('encrypt', $userWorkId);

            $notificationMessage = sprintf("%s is interested in your post!", $user->firstname);
            $timeSent = new TimeSent();
            $data = ["actor" => $userWork->user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time",'link' => '/innocreatives/' . $hash, "verb" => "notification", "object" => "3"];
            $streamService->addActivityToFeed($userWork->user_id, $data);

            $allInterests = UserWorkInterestsLinktable::select("*")->where("user_work_id", $userWorkId)->get();
            return count($allInterests);

        }

        public function disInterestPost($request){
            $userWorkId = $request->input("user_work_id");
            $user = User::select("*")->where("id", Session::get("user_id"))->first();

            $interest = UserWorkInterestsLinktable::select("*")->where("user_work_id", $userWorkId)->where("user_id", $user->id)->first();
            $interest->delete();

            $allInterests = UserWorkInterestsLinktable::select("*")->where("user_work_id", $userWorkId)->get();

            return count($allInterests);
        }
    }