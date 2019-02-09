<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 29/01/2019
     * Time: 18:26
     */

    namespace App\Services\FeedServices;
    use App\Emoji;
    use App\Services\Images\ImageProcessor;
    use App\Services\Paths\PublicPaths;
    use App\Services\TimeSent;
    use App\User;
    use App\UserFollowLinktable;
    use App\UserWork;
    use App\UserWorkComment;
    use App\UserworkPointLinktable;
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
            $data = ["actor" => $userWorkComment->userWork->user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3", "link" => "/innocreatives"];
            $streamService->addActivityToFeed($userWorkComment->userWork->user_id, $data);


            $messageArray = ["message" => $comment, "timeSent" => $timeSent->time];
            echo json_encode($messageArray);
            die();
        }

        public function postNewUserWorkPost($request){
            $userId = $request->input("user_id");
            $file = $request->file("image");
            $percentage = $request->input("percentageProgress");
            $link = $request->input("imageLink");
            $description = htmlspecialchars($request->input("newUserWorkDescription"));

            $userWork = new UserWork();
            $userWork->description = $description;
            $userWork->user_id = $userId;
            if($percentage){
                $userWork->progress = $percentage;
            }
            $userWork->save();

            if($link){
                $userWork->link = $link;
            }
            if($file) {
                $size = ImageProcessor::formatBytes($file->getSize());
                if ($size < 8) {
                    $imageProcessor = new ImageProcessor();
                    $user = User::select("*")->where("id", $userId)->first();
                    $uniqueId = uniqid($userWork->id);

                    //Creates and uploads Original image
                    $filename = PublicPaths::getFileName($uniqueId, $file);
                    $path = PublicPaths::getUserWorkDir($user, $userWork, $filename);
                    $imageProcessor->upload($file->getRealPath(), $path, false, $file->getRealPath());

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
                    return redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    $userWork->delete();
                    return redirect("/innocreatives")->withErrors("Image is too large. The max upload size is 8MB");
                }
            } else {
                return redirect("/innocreatives")->withErrors("Oops. Something went wrong. Please try again");
            }
        }

        public function plusPointPost($request){
            $userWorkId = $request->input("user_work_id");

            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();

            $existingPoint = UserworkPointLinktable::select("*")->where("user_work_id", $userWorkId)->where("user_id", $user->id)->count();
            if($existingPoint < 1 ) {
                $userworkPointLinktable = new UserworkPointLinktable();
                $userworkPointLinktable->user_work_id = $userWorkId;
                $userworkPointLinktable->user_id = $user->id;
                $userworkPointLinktable->save();
            }
            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();

            return count($userWork->getPoints());
        }

        public function minusPointPost($request){
            $userWorkId = $request->input("user_work_id");

            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();

            $existingPoint = UserworkPointLinktable::select("*")->where("user_work_id", $userWorkId)->where("user_id", $user->id)->first();
            if(count($existingPoint) > 0 ) {
                $existingPoint->delete();
            }
            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            return count($userWork->getPoints());
        }
    }