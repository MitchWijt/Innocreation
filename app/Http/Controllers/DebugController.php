<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
use App\UserMessage;
use App\WorkspaceShortTermPlannerBoard;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Mailgun\Mailgun;
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
use GetStream\StreamLaravel\Facades\FeedManager;
use Session;

class DebugController extends Controller
{
    /**
     *
     */
    public function test(){
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
//            $user = User::select("*")->where("id", 10)->first();
//            $feed = FeedManager::getUserFeed($user->id);
//            dd($feed);

//        if($this->authorized(true)){


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
//        }
    }
}
