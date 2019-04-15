<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 17/03/2019
     * Time: 11:06
     */

    namespace App\Services\AdminServices;


    use App\Services\TimeSent;
    use App\User;
    use App\UserWork;
    use Illuminate\Support\Facades\Storage;

    class AdminFeedPostsService {
        public function index(){
            return view("/admin/feedPosts/index");
        }

        public function approvePost($request, $streamService, $mailgunService, $userWorkPostService){
            $userWorkId = $request->input("userWorkId");

            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            $userWork->approved = 1;
            $userWork->save();

            $user = User::select("*")->where("id", $userWork->user_id)->first();
            $mailgunService->saveAndSendEmail($user, "Update regarding your passion post!", view("/templates/sendApprovedPost", compact("user", "userWork")));

            $notificationMessage = "Your passion post on the feed has been approved, Thank you for sharing!";
            $timeSent = new TimeSent();
            $data = ["actor" => $userWork->user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3", "link" => "innocreatives/" . $userWorkPostService->encrypt_decrypt("encrypt", $userWorkId)];
            $streamService->addActivityToFeed($userWork->user_id, $data);

            return redirect("/admin/innocreatives-posts");
        }

        public function declinePost($request, $streamService, $mailgunService, $userWorkPostService){
            $userWorkId = $request->input("userWorkId");

            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            $userWork->approved = 0;
            $userWork->save();

            $user = User::select("*")->where("id", $userWork->user_id)->first();
            $mailgunService->saveAndSendEmail($user, "Update regarding your passion post!", view("/templates/sendDeclinedPost", compact("user", "userWork")));

            $notificationMessage = "Your passion post has been declined, We still thank you for sharing!";
            $timeSent = new TimeSent();
            $data = ["actor" => $userWork->user_id , "category" => "notification", "message" => $notificationMessage, "timeSent" => "$timeSent->time", "verb" => "notification", "object" => "3", "link" => "innocreatives/" . $userWorkPostService->encrypt_decrypt("encrypt", $userWorkId)];
            $streamService->addActivityToFeed($userWork->user_id, $data);

            $exists = Storage::disk('spaces')->exists("users/" . $user->slug . "/userworks/" . $userWorkId . "/" . $userWork->content . "." . $userWork->extension);
            if ($exists) {
                Storage::disk('spaces')->delete("users/" . $user->slug . "/userworks/" . $userWorkId . "/" . $userWork->content . "." . $userWork->extension);
                Storage::disk('spaces')->delete("users/" . $user->slug . "/userworks/" . $userWorkId . "/" . $userWork->content . "-placeholder." . $userWork->extension);
            }
            $userWork->delete();

            return redirect("/admin/innocreatives-posts");
        }
    }