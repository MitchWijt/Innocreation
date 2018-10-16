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
use Mailgun\Mailgun;

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
    public function fire(){
        date_default_timezone_set("Europe/Amsterdam");
        $users = User::select("*")->where("online_timestamp", "!=", null)->get();
        foreach($users as $user){
            $today = new DateTime(date("Y-m-d H:i:s"));
            $date = new DateTime(date("Y-m-d H:i:s",strtotime($user->online_timestamp)));
            $interval = $date->diff($today);
            if($interval->format('%i') >= 10 || $interval->format('%h') > 1 || $interval->format('%Y') > 1 || $interval->format('%m') > 1 || $interval->format('%d') > 1){
                $user->active_status = "offline";
                $user->save();
            }
        }
    }
}