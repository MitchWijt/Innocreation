<?php

namespace App\Console\Commands;

use App\User;
use App\UserMessage;
use App\MailMessage;
use Dotenv\Dotenv;
use Illuminate\Console\Command;
use App\Services\AppServices\MailgunService as MailgunService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Mailgun\Mailgun;

class WelcomeMails extends Command
{

    protected $signature = 'welcome:mail';


    protected $description = 'Command description';

    /**
     * The mailgun e-mail service.
     *
     * @var MailgunService
     */

    protected $mailgunService;

    public function __construct(MailgunService $mailgunService)
    {
        parent::__construct();

        $this->mailgunService = $mailgunService;
    }


    public function handle() {
        dd("d");
//        date_default_timezone_set("Europe/Amsterdam");
////        $today = date("Y-m-d H:i:s");
////        $user = User::select("*")->where("id", 10)->first();
//        $this->mailgunService->saveAndSendEmail(10, "test", "<p>hoi</p>");



//        $users = User::select("*")->get();
//        foreach($users as $user){
//            $created_at = date("Y-m-d H", strtotime($user->created_at . "3 hour"));
//            if($created_at == $today){
//                $mailgunService->saveAndSendEmail($user, "Some tips for you!", view("templates/sendLateWelcomeMail", compact("user")));
//            }
//        }
    }
}
