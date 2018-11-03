<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 15-10-18
 * Time: 05:20
 */

namespace App\Services\AppServices;
use App\MailMessage;
use App\User;
use App\UserMessage;
use Mailgun\Mailgun;

class MailgunService
{
    private $initialize;

    public function __construct() {
        $initialize = [
            $mgClient = new Mailgun(env('MG_API_KEY')),
            $domain = env("MG_DOMAIN")
        ];

        $this->initialize = $initialize;
    }

    public function saveAndSendEmail($to, $subject, $message, $from = 'Innocreation <info@innocreation.net>'){



        try {
            $mailMessage = new MailMessage();
            $mailMessage->receiver_user_id = $to->id;
            $mailMessage->subject = $subject;
            $mailMessage->message = $message;
            $mailMessage->created_at = date("Y-m-d H:i:s");
            $mailMessage->save();

            $user = User::select("*")->where("id", $mailMessage->receiver_user_id)->first();
            $mgClient = $this->initialize;
            $msg =  "1";
            $mgClient[0]->sendMessage($mgClient[1], array(
                'from' => $from,
                'to' => $user->email,
                'subject' => $mailMessage->subject,
                'html' => $mailMessage->message
            ), array(
                'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
            ));
            $msg = "2";
        } catch(\Exception $e) {
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = 1;
            $userMessage->time_sent = "2:03 AM";
            $userMessage->message = $msg;
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();
        }



    }

    public function getTimeSent(){
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        return $time;
    }
}