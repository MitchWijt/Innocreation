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

class WelcomeMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'welcome:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'WelcomeMail';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire(Mailgun $mailgunService){
        date_default_timezone_set("Europe/Amsterdam");
//        $today = date("Y-m-d H:i:s");
        $user = User::select("*")->where("id", 10)->first();
        $mailgunService->saveAndSendEmail($user, "test", view("templates/sendLateWelcomeMail", compact("user")));
//        $users = User::select("*")->get();
//        foreach($users as $user){
//            $created_at = date("Y-m-d H", strtotime($user->created_at . "3 hour"));
//            if($created_at == $today){
//                $mailgunService->saveAndSendEmail($user, "Some tips for you!", view("templates/sendLateWelcomeMail", compact("user")));
//            }
//        }
    }
}