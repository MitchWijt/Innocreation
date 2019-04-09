<?php

namespace App\Http\Controllers;

use App\Payments;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\MollieService;
use App\Services\Payments\PaymentService;
use App\Services\TimeSent;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Http\Request;
use Auth;
use Session;

class DebugController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function test(Request $request, MailgunService $mailgunService) {
//        $paymentTable = Payments::select("*")->where("payment_id", "tr_7BzCGMKTud")->first();
//        $user = User::select("*")->where("id", 11)->first();
//        $mollie = new MollieService();
//        $mollie->cancelAllSubscriptions($user);


        dd(error_log("error moite", 3, "/var/log/mollie/error_log.txt"));


        die('test');
    }
}
