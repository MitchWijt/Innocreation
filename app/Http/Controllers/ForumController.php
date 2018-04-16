<?php

namespace App\Http\Controllers;

use App\ForumMainTopic;
use App\ForumMainTopicType;
use App\ForumThread;
use App\User;
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
        $threads = ForumThread::select("*")->where("main_topic_id", $forumMainTopic->id)->paginate(2);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
