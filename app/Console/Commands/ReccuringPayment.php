<?php

namespace App\Console\Commands;

use App\Invoice;
use App\MailMessage;
use DateTime;
use Illuminate\Console\Command;
use App\SiteSetting;
use App\User;
use App\Payments;
use App\TeamPackage;
use App\SplitTheBillLinktable;
use App\Team;
use App\Services\AppServices\MailgunService as Mailgun;

class ReccuringPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'recurring:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RecurringPayment';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire(Mailgun $mailgunService){
        date_default_timezone_set("Europe/Amsterdam");
        $users = User::select("*")->where("online_timestamp", "!=", null)->get();
        foreach($users as $user){
            if($user->active_status == "online"){
                $user->active_status = "offline";
                $user->save();
            }
        }
    }
}