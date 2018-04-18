<?php

namespace App\Http\Controllers;

use App\ForumMainTopic;
use App\ForumMainTopicType;
use App\ForumThread;
use App\ForumThreadComment;
use App\Team;
use App\User;
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
        $threads = ForumThread::select("*")->where("main_topic_id", $forumMainTopic->id)->orderBy("created_at", "DESC")->paginate(2);
        if(Session::has("user_id")) {
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
        } else {
            $user = false;
        }

        return view("/public/forum/forumMainTopicThreads", compact("forumMainTopic", "threads", "user"));


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
        $forumThreadComments = ForumThreadComment::select("*")->where("thread_id", $forumThread->id)->orderBy("created_at", "DESC")->paginate(2);
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
    public function destroy($id)
    {
        //
    }
}
