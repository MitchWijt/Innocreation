<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\Team;
use App\UserChat;
use App\UserMessage;
use App\UserWork;
use App\WorkspaceShortTermPlannerBoard;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\ServiceReview;
use App\MailMessage;
use App\Payments;
use App\SiteSetting;
use App\TeamPackage;
use App\SplitTheBillLinktable;
use App\Http\Requests;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Spipu\Html2Pdf\Html2Pdf;
use App\Invoice;
use GetStream;
use DateTime;
use GetStream\StreamLaravel\Facades\FeedManager;
use App\Services\AppServices\UnsplashService as Unsplash;
use App\Services\AppServices\MailgunService as Mailgun;
use Session;
use Spipu\Html2Pdf\Tag\Html\Em;

class DebugController extends Controller
{
    /**
     *
     */

    public function test(Request $request, Unsplash $unsplash, Mailgun $mailgunService) {
        die('test');

//        $client = $this->getService("stream");
//        $messageFeed = $client->feed('user', 10);
//
////        if($userChat->receiver->active_status == "online") {
//        // Add the activity to the feed
//        $data = [
//            "actor" => "10",
//            "status" => "online",
//            "userId" => "14",
//            "userChatId" => "28",
//            "verb" => "userMessage",
//            "object" => "3",
//        ];
//        $messageFeed->addActivity($data);
//        dd(bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)));
//        if($this->authorized(true)) {

////            $messageFeed = $client->feed('timeline', 10);
//
//            $messageFeed2 = $client->feed('timeline', 11);
////            $fdsa = FeedManager::getUserFeed(10);
//
//            $response = $this->getTimeSent();

//            // Add the activity to the feed
//            $data = [
//                "actor"=> "10",
//                "receiver"=> "14",
//                "userChat"=> "28",
//                "message"=> "hoi",
//                "timeSent"=> "2 PM",
//                "verb"=>"userMessage",
//                "object"=>"3",
//            ];
//
//            $ericFeed->addActivity($data);
//
//            $token = $ericFeed->getToken();
//            dd($token);
//
//            $response = $ericFeed->getActivities();
//            dd($response);
//            $feed = FeedManager::getUserFeed($user->id);
//            dd($feed);


//        $user = User::select("*")->where("id", 10)->first();
//        $this->saveAndSendEmail($user, 'Welcome to Innocreation!', view("/templates/sendWelcomeMail", compact("user")));

//       $mollie = $this->getService("mollie");
//
//        $customer = $mollie->customers->get($user->mollie_customer_id);
//        $subscriptions = $customer->subscriptions();
//
//        foreach($subscriptions as $subscription){
//            $customer->cancelSubscription($subscription->id);
//        }


    }
}
