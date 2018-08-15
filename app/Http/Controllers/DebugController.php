<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
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
use Spipu\Html2Pdf\Html2Pdf;
use App\Invoice;
use Session;

class DebugController extends Controller
{
    /**
     *
     */
    public function test(){
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
    }
}
