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

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){
            dd(bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)));
//            $html2pdf = new Html2Pdf();
//            $html2pdf->writeHTML("<p>test</p>");
//            $html2pdf->output('pdf_demo.pdf', 'D');
            die("test");
//          SUBSEQUENT PAYMENT
//            $data = array("amount" => array("value" => 2000, "currency" => "EUR"), "reference" =>  15, "merchantAccount" => "InnocreationNET", "shopperReference" => "Marcel Wijt", "selectedRecurringDetailReference" => 8315325486768463232323, "recurring" => array("contract" => "RECURRING"), "shopperInteraction" => "ContAuth");
//            $data_string = json_encode($data);
//
//            $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                    'Authorization: Basic '. base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
//                    'Content-Type: application/json',
//                    'Content-Length:' . strlen($data_string))
//            );
//            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//
//            //execute post
//            $result = curl_exec($ch);
//            $resultAuthorization = json_decode($result);
//            dd($resultAuthorization);
//            //close connection
//            curl_close($ch);

        }
    }
}
