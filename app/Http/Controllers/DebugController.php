<?php

namespace App\Http\Controllers;

use App\Payments;
use App\Services\AppServices\MollieService;
use App\TeamPackage;
use App\User;
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

    public function test(Request $request) {
//        $paymentTable = Payments::select("*")->where("payment_id", "tr_7BzCGMKTud")->first();
        $user = User::select("*")->where("id", 11)->first();
        $mollie = new MollieService();
        $mollie->cancelAllSubscriptions($user);

        die('test');
    }
}
