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
        if($this->authorized()) {
            $mailTemplates = MailTemplate::select("*")->get();
            return view("/admin/massMessage/massMessageIndex", compact("mailTemplates"));
        }
    }

    public function sendMassEmailAction(Request $request){
        if($this->authorized()){
            $message = $request->input("emailMessage");
            $subject = $request->input("subject");

            $mgClient = $this->getService("mailgun");
            $mgClient[0]->sendMessage($mgClient[1], array(
                'from' => "innocreation <info@innocreation.net>",
                'to' => "mitchel@wijt.net",
                'subject' => $subject,
                'html' => $message
            ), array(
                'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
            ));

            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }
}