<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
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

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
            $user = User::select("*")->where("id", 10)->first();
            $invoiceDate = date("F");
            $this->saveAndSendEmail($user, "$invoiceDate invoice is ready!", view("/templates/sendInvoiceReady", compact("user")));

            die("test");
        }
    }
}
