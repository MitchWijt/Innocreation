<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
use Illuminate\Http\Request;
use Mailgun\Mailgun;
use App\User;
use App\ServiceReview;
use App\MailMessage;

use App\Http\Requests;

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
            die("test");
        }
    }
}
