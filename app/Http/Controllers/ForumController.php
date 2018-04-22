<?php

namespace App\Http\Controllers;

use App\ForumMainTopic;
use App\ForumMainTopicType;
use App\ForumThread;
use App\ForumThreadComment;
use App\Page;
use App\Team;
use App\User;
use App\UserFollowingTopicsLinktable;
use App\UserMessage;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forums()
    {
        $forumMainTopicTypes = ForumMainTopicType::select("*")->get();
        return view("/public/forum/forums", compact("forumMainTopicTypes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function forumMainTopicThreads($id)
    {
        $forumMainTopic = ForumMainTopic::select("*")->where("id", $id)->first();
        $threads = ForumThread::select("*")->where("main_topic_id", $forumMainTopic->id)->orderBy("created_at", "DESC")->paginate(10);
        if(Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $isFollowingTopic = UserFollowingTopicsLinktable::select("*")->where("user_id", $user->id)->where("forum_main_topic_id", $id)->get();
            $followingTopicUser = UserFollowingTopicsLinktable::select("*")->where("forum_main_topic_id", $id)->where("user_id", $user->id)->first();
            if($followingTopicUser){
                $followingTopicUser->seen_at = date("Y-m-d H:i:s");
                $followingTopicUser->save();
            }
        } else {
            $user = false;
            $isFollowingTopic = false;
        }

        return view("/public/forum/forumMainTopicThreads", compact("forumMainTopic", "threads", "user", "isFollowingTopic"));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forumThreadAction($slug, $id)
    {
        $forumMainTopic = ForumMainTopic::select("*")->where("slug", $slug)->first();
        $forumThread = ForumThread::select("*")->where("id", $id)->first();
        $loggedIn = false;
//        $forumThread->views = $forumThread->views + 1;
//        $forumThread->save();
        $allForumThreadComments = ForumThreadComment::select("*")->where("thread_id", $forumThread->id)->get();
        $forumThreadComments = ForumThreadComment::select("*")->where("thread_id", $forumThread->id)->orderBy("created_at", "DESC")->paginate(10);
        if($this->isLoggedIn()){
            $loggedIn = true;
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/forum/forumThread", compact("forumThread", "forumMainTopic", "forumThreadComments", "loggedIn", "user", "allForumThreadComments"));
        } else {
            return view("/public/forum/forumThread", compact("forumThread", "forumMainTopic", "forumThreadComments", "loggedIn", "allForumThreadComments"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postThreadCommentAction(Request $request)
    {
        $user_id = $request->input("user_id");
        $thread_id = $request->input("thread_id");
        $comment = $request->input("forumThreadComment");

        $forumThreadComment = new ForumThreadComment();
        $forumThreadComment->thread_id = $thread_id;
        $forumThreadComment->creator_user_id = $user_id;
        $forumThreadComment->message = $comment;
        $forumThreadComment->created_at = date("Y-m-d H:i:s");
        $forumThreadComment->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shareThreadWithTeamAction(Request $request)
    {
        $user_id = $request->input("user_id");
        $user = User::select("*")->where("id", $user_id)->first();
        $thread_id = $request->input("thread_id");
        $link = $request->input("thread_link");

        $forumThread = ForumThread::select("*")->where("id", $thread_id)->first();
        $message = new UserMessage();
        $message->sender_user_id = $user->id;
        $message->team_id = $user->team_id;
        $message->message = "Check out this form thread: <a class='regular-link' target='_blank' href='$link'>$forumThread->title</a>";
        $message->time_sent = $this->getTimeSent();
        $message->created_at = date("Y-m-d H:i:s");
        $message->save();
        return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Thread link has been sent in your team chat");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNewThreadAction(Request $request)
    {
        $user_id = $request->input("user_id");
        $forumMainTopicId = $request->input("forum_main_topic_id");
        $title = $request->input("thread_title");
        $message = $request->input("thread_message");

//        $page = new Page();
//        $page->page_type_id = 1;
//        $page->title = "Forum guidelines";
//        $page->content = htmlspecialchars($message);
//        $page->created_at = date("Y-m-d H:i:s");
//        $page->save();

        $forumThread = new ForumThread();
        $forumThread->main_topic_id = $forumMainTopicId;
        $forumThread->creator_user_id = $user_id;
        $forumThread->title = $title;
        $forumThread->message = $message;
        $forumThread->created_at = date("Y-m-d H:i:s");
        $forumThread->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function followMainTopicAction(Request $request){
        $userId = $request->input("user_id");
        $forumMainTopicId = $request->input("forum_main_topic_id");

        $followingTopicUser = new UserFollowingTopicsLinktable();
        $followingTopicUser->user_id = $userId;
        $followingTopicUser->forum_main_topic_id = $forumMainTopicId;
        $followingTopicUser->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function unfollowMainTopicAction(Request $request){
        $userId = $request->input("user_id");
        $forumMainTopicId = $request->input("forum_main_topic_id");

        $followingTopicUser = UserFollowingTopicsLinktable::select("*")->where("user_id", $userId)->where("forum_main_topic_id", $forumMainTopicId)->first();
        $followingTopicUser->delete();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function followedTopicsUserAction()
    {
        $userId = Session::get("user_id");
        $user = User::select("*")->where("id", $userId)->first();
        $followingTopicsUser = UserFollowingTopicsLinktable::select("*")->where("user_id", $userId)->get();
        return view("/public/forum/followingTopicsUser", compact("user", "followingTopicsUser"));
    }

    public function forumActivityTimeline(){
        return view("/public/forum/forumActivityTimeline");
    }

    public function getDataForumActivityTimelineAction(){
        $today = date("Y-m-d H:i:s");
        $forumThreads = ForumThread::select("*")->orderBy("created_at", "DESC")->get();
        $forumThreadComments = ForumThreadComment::select("*")->orderBy("created_at", "DESC")->get();
        return view("/public/forum/shared/_timelineItem", compact("forumThreadComments", "forumThreads"));
    }

    public function searchInForumAction(Request $request){
        $forumThreadResults = [];
        $forumMainTopicResults = [];
        $forumThreadCommentResults = [];

        $input = ucfirst($request->input("searchForumInput"));
        $forumThreads = ForumThread::select("*")->get();
        $forumThreadComments = ForumThreadComment::select("*")->get();
        $forumMainTopics = ForumMainTopic::select("*")->get();
        if(strlen($input) == 0){
            return view("/public/forum/forumSearchResults");
        } else {
            foreach($forumThreads as $forumThread){
                if(strpos($forumThread->title, $input) !== false){
                    array_push($forumThreadResults, $forumThread);
                }
            }
            foreach($forumThreadComments as $forumThreadComment){
                if(strpos($forumThreadComment->message, $input) !== false){
                    array_push($forumThreadCommentResults, $forumThreadComment);
                }
            }
            foreach($forumMainTopics as $forumMainTopic) {
                if(strpos($forumMainTopic->title, $input) !== false){
                    array_push($forumMainTopicResults, $forumMainTopic);
                }
            }

            return view("/public/forum/forumSearchResults", compact("forumThreadResults", "forumThreadCommentResults", "forumMainTopicResults"));
        }
    }
}
