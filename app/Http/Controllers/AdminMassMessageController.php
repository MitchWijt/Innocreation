<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\MailMessage;
use App\MailTemplate;
use App\Team;
use App\UserChat;
use Faker\Provider\Payment;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Country;
use Auth;
use Session;
use App\InviteRequestLinktable;

class AdminMassMessageController extends Controller
{
    public function massMessageIndexAction(){
        $mailTemplates = MailTemplate::select("*")->get();
        return view("/admin/massMessage/massMessageIndex", compact("mailTemplates"));
    }
}