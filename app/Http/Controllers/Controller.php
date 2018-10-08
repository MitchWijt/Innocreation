<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
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

    public function getTimeSent(){
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        return $time;
    }

    public function getService($service){
        if($service == "mailgun") {
            $mailgun = [
                $mgClient = new Mailgun('key-8802b754cc5279a431547c306e298ead'),
                $domain = "mg.innocreation.net"
            ];
            return $mailgun;
        } else if($service == "mollie"){
            $fullDomain = $_SERVER['HTTP_HOST'];
            $domainExplode = explode(".", $fullDomain);
            if($domainExplode[0] == "secret") {
                $apiKey = "test_5PW69PFKTaBS6E9A4Sgb3gzWjQ5k4v";
            } else {
                $apiKey = "live_BdmQNxeQ3zaQrqbmPepVSS33D3QVKe";
            }
            $mollie = new MollieApiClient();
            $mollie->setApiKey($apiKey);
            return $mollie;
        } else if("stream"){
            $client = new GetStream\Stream\Client('ujpcaxtcmvav', 't7bkq85zvutj4qnyvt3kkv7uts9mfaxz99cuv52ctgqy7gh9up3scpzvms99s8k6');
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

    public function calculateAdyenSignature($pairs, $key, $binaryHmacKey){
        ksort($pairs, SORT_STRING);
        foreach ($pairs as $key => $value) {
            $escapedPairs[$key] = str_replace(':','\\:', str_replace('\\', '\\\\', $value));
        }

        $signingString = implode(":", array_merge(array_keys($escapedPairs), array_values($escapedPairs)));
        $binaryHmac = hash_hmac('sha256', $signingString, $binaryHmacKey, true);
        $signature = base64_encode($binaryHmac);
        return $signature;
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

    public function export()
    {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $reviews = User::select("*")->where("id", 10)->get();
        $columns = array('ReviewID', 'Provider', 'Title', 'Review', 'Location', 'Created', 'Anonymous', 'Escalate', 'Rating', 'Name');

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($reviews as $review) {
                dd($review);
                fputcsv($file, array($review->id, $review->firstname, $review->lastname, $review->middlename, $review->city, $review->country_id, $review->slug, $review->hash, $review->introduction, $review->created_at));
            }
            fclose($file);
        };
        response()->download("test.csv", "test.csv", $headers);
    }

    public function csv(){

    }
    public function download()
    {
        $list = User::select("*")->where("id", 10)->get()->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));



        $FH = fopen('php://output', 'w');
        foreach ($list as $row) {
            fputcsv($FH, $row, ",");
        }
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=galleries.csv');
        fpassthru($FH);
    }

    public function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        // loop over the input array
        foreach ($array as $line) {
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter);
        }
        // reset the file pointer to the start of the file
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // make php send the generated csv lines to the browser

    }
}

    date_default_timezone_set("Europe/Amsterdam");
