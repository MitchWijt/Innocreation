<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamProduct;
use App\TeamProductComment;
use App\TeamProductLinktable;
use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserUpvoteLinktable;
use App\UserWork;
use App\UserWorkComment;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TeamProductsAction($slug = null) {
        $title = "New innovative products";
        $teamProducts = TeamProduct::select("*")->get();
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        if($slug) {
            $teamProductSlug = TeamProduct::select("slug")->where("slug", $slug)->first();
            if($user){
                return view("/public/feed/teamProducts", compact("teamProducts", "teamProductSlug", "user", "title"));
            } else {
                return view("/public/feed/teamProducts", compact("teamProducts", "teamProductSlug", "title"));
            }
        } else {
            if($user){
                return view("/public/feed/teamProducts", compact("teamProducts", "user", "title"));
            } else {
                return view("/public/feed/teamProducts", compact("teamProducts", "title"));
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function likeTeamProductAction(Request $request) {
        if($this->authorized()){
            $teamProductId = $request->input("team_product_id");
            $userId = Session::get("user_id");

            $teamProductLinktable = new TeamProductLinktable();
            $teamProductLinktable->team_product_id = $teamProductId;
            $teamProductLinktable->user_id = $userId;
            $teamProductLinktable->liked = 1;
            $teamProductLinktable->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function favoriteTeamProductAction(Request $request) {
     //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSearchedUsersTeamProductAction(Request $request) {
        $searchInput = $request->input("searchInput");
        $usersArray = [];
        $users = User::select("*")->get();
        if(strlen($searchInput) > 0) {
            foreach ($users as $user) {
                if (strpos($user->getName(), ucfirst($searchInput)) !== false && Session::get("user_id") != $user->id) {
                    array_push($usersArray, $user);
                }
            }
        } else {
            $usersArray = false;
        }
        return view("/public/feed/shared/_sharedUsersResult", compact("usersArray"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shareFeedPostAction(Request $request) {
        if($this->authorized()){
            $userIds = $request->input("userIds");
            $teamProductId = $request->input("team_product_id");
            $sharedMessage = $request->input("shareProductMessage");

            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if($userIds) {
                foreach ($userIds as $selectedUser) {
                    $existingUserChat = UserChat::select("*")->where("creator_user_id", $selectedUser)->where("receiver_user_id", $user->id)->orWhere("creator_user_id", $user->id)->where("receiver_user_id", $selectedUser)->first();
                    if (count($existingUserChat) > 0) {
                        $message = new UserMessage();
                        $message->sender_user_id = $user->id;
                        $message->message = $sharedMessage;
                        $message->user_chat_id = $existingUserChat->id;
                        $message->time_sent = $this->getTimeSent();
                        $message->created_at = date("Y-m-d H:i:s");
                        $message->save();
                    } else {
                        $userChat = new UserChat();
                        $userChat->creator_user_id = $user->id;
                        $userChat->receiver_user_id = $selectedUser;
                        $userChat->created_at = date("Y-m-d H:i:s");
                        $userChat->save();

                        $message = new UserMessage();
                        $message->sender_user_id = $user->id;
                        $message->message = $sharedMessage;
                        $message->user_chat_id = $userChat->id;
                        $message->time_sent = $this->getTimeSent();
                        $message->created_at = date("Y-m-d H:i:s");
                        $message->save();
                    }
                }
            } else {
                $message = new UserMessage();
                $message->sender_user_id = $user->id;
                $message->message = $sharedMessage;
                $message->team_id = $user->team_id;
                $message->time_sent = $this->getTimeSent();
                $message->created_at = date("Y-m-d H:i:s");
                $message->save();
            }

            if($teamProductId) {
                $teamProductLinktable = TeamProductLinktable::select("*")->where("team_product_id", $teamProductId)->where("user_id", $user->id)->first();
                if (count($teamProductLinktable) > 0) {
                    $teamProductLinktable->shared = 1;
                    $teamProductLinktable->save();
                } else {
                    $teamProductLinktable = new TeamProductLinktable();
                    $teamProductLinktable->shared = 1;
                    $teamProductLinktable->save();
                }
            }

            return redirect($_SERVER["HTTP_REFERER"])->with("success", "Shared team product");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postTeamProductCommentAction(Request $request) {
        $senderUserId = $request->input("sender_user_id");
        $teamProductId = $request->input("team_product_id");
        $comment = $request->input("comment");

        $teamProductComment = new TeamProductComment();
        $teamProductComment->team_product_id = $teamProductId;
        $teamProductComment->sender_user_id = $senderUserId;
        $teamProductComment->message = $comment;
        $teamProductComment->time_sent = $this->getTimeSent();
        $teamProductComment->created_at = date("Y-m-d H:i:s");
        $teamProductComment->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function workFeedIndexAction($id = null){
        $pageType = "innoCreatives";
        $totalAmount = UserWork::select("id")->count();
        if(Session::has("user_id")){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if($id){
                $sharedUserWorkId = $id;
                return view("/public/userworkFeed/index", compact("user", "pageType", "totalAmount", "sharedUserWorkId"));
            } else {
                return view("/public/userworkFeed/index", compact("user", "pageType", "totalAmount"));
            }
        } else {
            if($id){
                $sharedUserWorkId = $id;
                return view("/public/userworkFeed/index", compact( "pageType", "totalAmount", "sharedUserWorkId"));
            } else {
                return view("/public/userworkFeed/index", compact("pageType", "totalAmount"));
            }
        }

    }

    public function getUserworkPostsAction(){
        $userWorkPosts = UserWork::select("*")->orderBy("created_at", "DESC")->limit(15)->get();
        if(Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/userworkFeed/shared/_userworkPosts", compact("user", "userWorkPosts"));
        }
        return view("/public/userworkFeed/shared/_userworkPosts", compact("userWorkPosts"));
    }

    public function getMoreUserworkPostsAction(Request $request){
        $userworkArray = $request->input("userworkArray");
        $userWorkPosts = UserWork::select("*")->whereNotIn("id", $userworkArray)->orderBy("created_at", "DESC")->limit(15)->get();
        if(Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/userworkFeed/shared/_userworkPosts", compact("user", "userWorkPosts"));
        }
        return view("/public/userworkFeed/shared/_userworkPosts", compact("userWorkPosts"));
    }

    public function upvoteUserWorkAction(Request $request){
        $userWorkId = $request->input("userWorkId");
        if(Session::has("user_id")) {
            $userUpvote = new UserUpvoteLinktable();
            $userUpvote->user_id = Session::get("user_id");
            $userUpvote->user_work_id = $userWorkId;
            $userUpvote->save();

            $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
            $userWork->upvotes = $userWork->upvotes + 1;
            $userWork->save();
            return 1;
        } else {
            return 2;
        }
    }

    public function postUserWorkAction(Request $request){
        if($this->authorized()){
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
                $size = $this->formatBytes($file->getSize());
                if ($size < 8) {
                    $filename = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $file->getClientOriginalName());

                    $user = User::select("*")->where("id", $userId)->first();
                    Storage::disk('spaces')->put("users/$user->slug/userworks/$userWork->id/$filename", file_get_contents($file->getRealPath()), "public");

                    $userWork->content = $filename;
                    $userWork->created_at = date("Y-m-d H:i:s");
                    $userWork->save();
                    return redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    $userWork->delete();
                    return redirect("/account")->withErrors("Image is too large. The max upload size is 8MB");
                }
            } else {
                $userWork->created_at = date("Y-m-d H:i:s");
                $userWork->save();
                return redirect($_SERVER["HTTP_REFERER"]);
            }
        }
    }

    public function postUserWorkCommentAction(Request $request){
        if($this->authorized()){
            $senderUserId = $request->input("sender_user_id");
            $user_work_id = $request->input("user_work_id");
            $comment = $request->input("comment");

            $userWorkComment = new UserWorkComment();
            $userWorkComment->sender_user_id = $senderUserId;
            $userWorkComment->user_work_id = $user_work_id;
            $userWorkComment->time_sent = $this->getTimeSent();
            $userWorkComment->description = $comment;
            $userWorkComment->created_at = date("Y-m-d H:i:s");
            $userWorkComment->save();


            $messageArray = ["message" => $comment, "timeSent" => $this->getTimeSent()];
            echo json_encode($messageArray);

        }
    }
}
