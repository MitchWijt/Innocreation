<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 15-10-18
 * Time: 05:20
 */

namespace App\Services\AppServices;
use App\MailMessage;
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
        $mgClient = $this->initialize;
        $mgClient[0]->sendMessage($mgClient[1], array(
            'from' => $from,
            'to' => $to->email,
            'subject' => $subject,
            'html' => $message
        ), array(
            'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
        ));

        $mailMessage = new MailMessage();
        $mailMessage->receiver_user_id = $to->id;
        $mailMessage->subject = $subject;
        $mailMessage->message = $message;
        $mailMessage->created_at = date("Y-m-d");
        $mailMessage->save();
    }

    public function getTimeSent(){
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        return $time;
    }
}