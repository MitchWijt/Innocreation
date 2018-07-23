<?php

namespace App\Http\Controllers;

use App\Team;
use App\UserChat;
use Illuminate\Http\Request;
use Mailgun\Mailgun;
use App\User;
use App\ServiceReview;
use App\MailMessage;

use App\Http\Requests;

class DebugController extends Controller
{
    public function test(){
        if($this->authorized(true)){

//            $HMAC_KEY = "BA15F61D808D61044A97167A6F00732C0144E7BB020900389CE8560739AF88E0";
//            $binaryHmacKey = pack("H*" , $HMAC_KEY);
//            $pairs["countryCode"] = "NL";
//            $pairs["shopperLocale"] = "en_GB";
//            $pairs["merchantReference"] = "paymentTest:143522\\64\\39255";
//            $pairs["merchantAccount"] = "InnocreationNET";
//            $pairs["sessionValidity"] = "2018-07-25T10:31:06Z";
//            $pairs["shipBeforeDate"] = "2018-07-30";
//            $pairs["paymentAmount"] = "1995";
//            $pairs["currencyCode"] = "EUR";
//            $pairs["skinCode"] = "iXpfcBwG";
//
//            $signature = $this->calculateAdyenSignature($pairs, $HMAC_KEY, $binaryHmacKey);
//
//            $pairs["merchantSig"] = $signature;
//            $queryString = http_build_query($pairs);
//            $testUrl = "https://test.adyen.com/hpp/directory.shtml" . "?" . $queryString;
//            $json = file_get_contents($testUrl);
//            dd(json_decode($json));

            $data = array("amount" => array("value" => 2000, "currency" => "EUR"), "reference" => "testpaymentCard", "merchantAccount" => "InnocreationNET");
            $data_string = json_encode($data);

//          header('Content-Type: application/json; charset=UTF-8', true);
            $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                'ws@Company.YourCompany:[puCnJ5TjHjTxjpa++rI1%UD~',
                    'Content-Type: application/json',
                    'Content-Length:' . strlen($data_string))
            );
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

            //execute post
            $result = curl_exec($ch);
            dd($ch);
            //close connection
            curl_close($ch);

            die("test");
        }
    }
}
