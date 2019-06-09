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
use App\TeamProjectTask;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Http\Request;
use Auth;
use Str;
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
        dd(file_get_contents("https://www.bol.com/nl/l/likeur/N/36806//?promo=dranken_360_5_likeur_afbeelding"));
        die('test');
    }
}
