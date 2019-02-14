<?php

namespace App\Http\Controllers;

use App\Emoji;
use App\Services\AppServices\StreamService;
use App\Services\FeedServices\FeedService;
use App\Services\FeedServices\UserworkPost;
use App\Services\Paths\PublicPaths;
use App\Team;
use App\TeamProduct;
use App\TeamProductComment;
use App\TeamProductLinktable;
use App\User;
use App\UserChat;
use App\UserFollowLinktable;
use App\UserMessage;
use App\UserUpvoteLinktable;
use App\UserWork;
use App\UserWorkComment;
use GetStream\Stream\Feed;
use GuzzleHttp\Psr7\Stream;
use Illuminate\Http\Request;
use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;
use App\Services\Images\ImageProcessor as ImageProcessor;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

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
        $title = "Share your work/story and connect!";
        $og_description = "Connect with fellow innocreators and start executing on your ideas!";
        $pageType = "noFooter";
        $totalAmount = UserWork::select("id")->count();
        $emojis = Emoji::select("*")->get();
        if(Session::has("user_id")){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if($id){
                $sharedUserWorkId = $id;
                return view("/public/userworkFeed/index", compact("user", "pageType", "totalAmount", "sharedUserWorkId", "title", "og_description", "emojis"));
            } else {
                return view("/public/userworkFeed/index", compact("user", "pageType", "totalAmount", "title", "og_description", "emojis"));
            }
        } else {
            if($id){
                $sharedUserWorkId = $id;
                return view("/public/userworkFeed/index", compact( "pageType", "totalAmount", "sharedUserWorkId", "title", "og_description", "emojis"));
            } else {
                return view("/public/userworkFeed/index", compact("pageType", "totalAmount", "title", "og_description", "emojis"));
            }
        }

    }

    public function unhashId(Request $request, UserworkPost $userworkPost){
        return $userworkPost->encrypt_decrypt("decrypt", $request->input("hash"));
    }

    public function getUserworkPostsAction(Request $request, FeedService $feedService){
        return $feedService->getUserworkPosts($request);
    }

    public function getMoreUserworkPostsAction(Request $request, FeedService $feedService){
        return $feedService->getMoreUserworkPosts($request);
    }

    public function postUserWorkAction(Request $request, FeedService $feedService, StreamService $streamService){
        if($this->authorized()){
            return $feedService->postNewUserWorkPost($request, $streamService);
        }
    }

    public function postUserWorkCommentAction(Request $request, UserworkPost $userworkPost, StreamService $streamService){
        if($this->authorized()){
            return $userworkPost->postComment($request, $streamService);
        }
    }

    public function plusPointPostAction(Request $request, UserworkPost $userworkPost, StreamService $streamService){
        return $userworkPost->plusPointPost($request, $streamService);
    }

    public function minusPointPostAction(Request $request, UserworkPost $userworkPost){
        return $userworkPost->minusPointPost($request);
    }

    public function openInterestsModal(Request $request, UserworkPost $userworkPost){
        return $userworkPost->interestModal($request);
    }

    public function deleteUserWorkPostAction(Request $request){
        $userWorkId = $request->input("userWorkId");
        $userId = Session::get("user_id");

        $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
        if($userWork->user_id == $userId){
            $userWork->delete();
            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully deleted your post");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Failed to delete the post");
        }
    }

    public function editUserWorkPostAction(Request $request){
        $userWorkId = $request->input("userWorkId");
        $userId = Session::get("user_id");
        $description = $request->input("newUserWorkDescription");

        $userWork = UserWork::select("*")->where("id", $userWorkId)->first();
        if($userWork->user_id == $userId){
            $userWork->description = $description;
            $userWork->save();
            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully edited your post!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Failed to edit the post");
        }

    }

    public function getUserWorkPostModal(Request $request, UserworkPost $userworkPost){
        return $userworkPost->getPostModal($request);
    }
}
