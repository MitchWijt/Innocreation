<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
use Illuminate\Http\Request;
use Mailgun\Mailgun;
use App\User;

use App\Http\Requests;

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
            $user = User::select("*")->where("id", 10)->first();
            $team = Team::select("*")->where("id", 4)->first();


            $mgClient = $this->getService("mailgun");
            $mgClient[0]->sendMessage($mgClient[1], array(
                'from' => 'Innocreation  <mitchel@innocreation.net>',
                'to' => $user->email,
                'subject' => "Accepted invitation!",
                'html' => view("/templates/sendInviteAcceptionTeam", compact("user", "team"))
            ), array(
                'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
            ));
            die("test");
        }
    }
}
