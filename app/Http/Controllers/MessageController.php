<?php

namespace App\Http\Controllers;

use App\SupportTicket;
use App\SupportTicketMessage;
use App\User;
use App\Team;
use App\UserChat;
use App\UserMessage;
use Session;
use App\TeamGroupChatLinktable;
use Illuminate\Http\Request;

use App\Http\Requests;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamChatMessagesAction()
    {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $messages = UserMessage::select("*")->where("team_id", $team->id)->get();

        return view("/public/shared/_messagesTeamChat", compact("messages", "user", "team"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamGroupChatMessagesAction(Request $request)
    {
        $groupChatId = $request->input("group_chat_id");
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("id", $user->team_id)->first();
        $groupChat = TeamGroupChatLinktable::select("*")->where("team_group_chat_id", $groupChatId)->first();
        return view("/public/shared/_messagesTeamGroupChat", compact("groupChat", "user", "team"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userChatMessagesAction(Request $request)
    {
        $userChatId = $request->input("user_chat_id");
        $user_id = Session::get("user_id");
        $userChat = UserChat::select("*")->where("id", $userChatId)->first();
        return view("/public/shared/_messagesUserChat", compact("user_id", "userChat"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSupportTicketMessagesAction(Request $request)
    {
        $admin = $request->input("admin");
        if($admin == 1) {
            $userId = Session::get("admin_user_id");
        } else {
            $userId = Session::get("user_id");
        }
        $ticketId = $request->input("ticket_id");
        $user = User::select("*")->where("id", $userId)->first();
        $supportTicket = SupportTicket::select("*")->where("id", $ticketId)->first();
        return view("/public/shared/_messagesSupportTickets", compact( "supportTicket", "user", "admin"));
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
