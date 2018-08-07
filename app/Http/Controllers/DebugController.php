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

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
                die("test");
        }
    }
}
