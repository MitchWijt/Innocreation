<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Http\Requests\Request;
use App\NeededExpertiseLinktable;
use App\User;
use Mollie\Api\MollieApiClient;
use Formatter;
use Redirect;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Session;
use GetStream;
use Response;
use Mailgun\Mailgun;
use App\MailMessage;

class Controller extends BaseController
{

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function isLoggedIn(){
        $bool = false;
        if(Session::has("user_id")){
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    public function authorized($admin = false){
        if($admin && $this->isLoggedIn()){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if(Session::get("user_role") == 1){
                return true;
            } else {
                redirect("/login")->withErrors("We're sorry, you don't have access to this part of the platform")->send();
            }
        } else {
            if($this->isLoggedIn()){
                return true;
            } else {
                redirect("/login")->withErrors("Your session has expired, please login again")->send();
            }
        }
    }

    public function getService($service){
        if($service == "mailgun") {
            $mailgun = [
                $mgClient = new Mailgun(env('MG_API_KEY')),
                $domain = env("MG_DOMAIN")
            ];
            return $mailgun;
        } else if($service == "mollie"){
            $fullDomain = $_SERVER['HTTP_HOST'];
            $domainExplode = explode(".", $fullDomain);
            if($domainExplode[0] == "secret") {
                $apiKey = env("MOLLIE_API_TEST");
            } else {
                $apiKey = env("MOLLIE_API_LIVE");
            }
            $mollie = new MollieApiClient();
            $mollie->setApiKey($apiKey);
            return $mollie;
        } else if("stream"){
            $client = new GetStream\Stream\Client(env("STREAM_API"), env("STREAM_SECRET"));
            return $client;
        }
    }

    public function getWebhookUrl($sub = false){
        $fullDomain = $_SERVER['HTTP_HOST'];
        $domainExplode = explode(".", $fullDomain);
        if($sub == false) {
            if ($domainExplode[0] == "secret") {
                $url = "https://secret.innocreation.net/webhook/mollieRecurring";
            } else {
                $url = "https://innocreation.net/webhook/mollieRecurring";
            }
        } else {
            if ($domainExplode[0] == "secret") {
                $url = "https://secret.innocreation.net/webhook/mollieRecurringPayment";
            } else {
                $url = "https://innocreation.net/webhook/mollieRecurringPayment";
            }
        }

        return $url;
    }

    public function saveAndSendEmail($to, $subject, $message, $from = 'Innocreation <info@innocreation.net>'){
        $mgClient = $this->getService("mailgun");
        $mgClient[0]->sendMessage($mgClient[1], array(
            'from' => $from,
            'to' => $to->email,
            'subject' => $subject,
            'html' => $message
        ), array(
            'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
        ));
        $mailMessage = new MailMessage();
        $mailMessage->receiver_user_id = $to->id;
        $mailMessage->subject = $subject;
        $mailMessage->message = $message;
        $mailMessage->created_at = date("Y-m-d");
        $mailMessage->save();

    }

    public function getControllerName(){
        $fullRoute = request()->route()->getAction()["controller"];
        $explode1 = explode("\\", $fullRoute);
        $explode2 = explode("@", $explode1[3]);
        $controller = $explode2[0];
        return $controller;
    }

    public function formatBytes($bytes, $precision = 2) {
        $unit = ["B", "KB", "MB", "GB"];
        $exp = floor(log($bytes, 1024)) | 0;
        if($unit[$exp] == "MB") {
            return round($bytes / (pow(1024, $exp)), $precision);
        } else if($unit[$exp] == "KB"){
            return 6;
        } else if($unit[$exp] == "GB"){
            return 9;
        }
    }

    public function getAllNeededExpertises(){
        $expertisesIdArray = [];
        $neededExpertises = NeededExpertiseLinktable::select("*")->get();
        foreach($neededExpertises as $neededExpertise){
            array_push($expertisesIdArray, $neededExpertise->expertise_id);
        }
        $expertiseIds = array_unique($expertisesIdArray);
        $expertises = Expertises::select("*")->whereIn("id", $expertiseIds)->get();
        return $expertises;
    }
}

    date_default_timezone_set("Europe/Amsterdam");
