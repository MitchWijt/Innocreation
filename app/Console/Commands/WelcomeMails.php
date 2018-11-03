<?php

namespace App\Console\Commands;

use App\User;
use App\UserMessage;
use Illuminate\Console\Command;
use App\Services\AppServices\MailgunService as MailgunService;
use Mailgun\Mailgun;

class WelcomeMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'welcome:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The mailgun e-mail service.
     *
     * @var MailgunService
     */

    protected $mailgunService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MailgunService $mailgunService)
    {
        parent::__construct();

        $this->mailgunService = $mailgunService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        date_default_timezone_set("Europe/Amsterdam");
//        $today = date("Y-m-d H:i:s");
        try {
            $user = User::select("*")->where("id", 10)->first();
            $this->mailgunService->saveAndSendEmail($user, "test", "<p>hoi</p>");
        } catch(\Exception $e) {
            $userMessage = new UserMessage();
            $userMessage->sender_user_id = 1;
            $userMessage->user_chat_id = 1;
            $userMessage->time_sent = "2:01 AM";
            $userMessage->message = $e->getMessage();
            $userMessage->created_at = date("Y-m-d H:i:s");
            $userMessage->save();
        }


//        $users = User::select("*")->get();
//        foreach($users as $user){
//            $created_at = date("Y-m-d H", strtotime($user->created_at . "3 hour"));
//            if($created_at == $today){
//                $mailgunService->saveAndSendEmail($user, "Some tips for you!", view("templates/sendLateWelcomeMail", compact("user")));
//            }
//        }
    }
}
