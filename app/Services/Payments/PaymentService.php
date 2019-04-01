<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 29/03/2019
 * Time: 13:50
 */

namespace App\Services\Payments;


use App\Payments;
use App\Services\AppServices\MollieService;
use App\Services\TimeSent;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\UserChat;
use App\UserMessage;

class PaymentService {
    public function createNewPayment($user, $amount, $reference, $status, $method, $subId = false, $url = false, $paymentId = false){
        $paymentTable = new Payments();
        $paymentTable->user_id = $user->id;
        $paymentTable->team_id = $user->team_id;
        if($paymentId) {
            $paymentTable->payment_id = $paymentId;
        }
        if($url) {
            $paymentTable->payment_url = $url;
        }
        $paymentTable->payment_method = $method;
        $paymentTable->amount = $amount;
        $paymentTable->reference = $reference;
        $paymentTable->payment_status = $status;
        if($subId) {
            $paymentTable->sub_id = $subId;
        }
        $paymentTable->created_at = date("Y-m-d H:i:s");
        $paymentTable->save();
    }

    public static function getPaymentRange($teamPackage){
        if($teamPackage->payment_preference == "monthly"){
            $range = "1 months";
        } else {
            $range = "12 months";
        }

        return $range;
    }

    public static function getWebhookUrlMollie($sub = false){
        if($sub == false) {
            $url = env("MOLLIE_WEBHOOK");
        } else {
            $url = env("MOLLIE_WEBHOOK_SUB");
        }
        return $url;
    }

    public static function getPaymentReference($userId){
        return uniqid($userId);
    }

    public static function rejectSplitTheBillPayment($user, $team, $mailgunService){
        $allSplitTheBillLinktables = SplitTheBillLinktable::select("*")->where("team_id", $team->id)->get();
        foreach ($allSplitTheBillLinktables as $allSplitTheBillLinktable) {
            if($allSplitTheBillLinktable->accepted == 0) {
                $recentPayment = $allSplitTheBillLinktable->user->getMostRecentOpenPayment();
                $recentPayment->payment_status = "Canceled";
                $recentPayment->save();
            } else {
                $recentPayment = $allSplitTheBillLinktable->user->getMostRecentPayment();
                $recentPayment->payment_status = "Refunded";
                $recentPayment->save();

                $mollie = new MollieService();
                $mollie->refundPayment($recentPayment->payment_id, $allSplitTheBillLinktable->amount);
                $mollie->cancelAllSubscriptions($allSplitTheBillLinktable->user);
            }

            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("id", $allSplitTheBillLinktable->id)->first();
            $splitTheBillLinktable->accepted = 0;
            $splitTheBillLinktable->save();
        }
        foreach($allSplitTheBillLinktables as $linktable){
            $linktable->delete();
        }

        $team = $team = Team::select("*")->where("id", $user->team_id)->first();
        $team->split_the_bill = 0;
        $team->save();

        $teamPackage = TeamPackage::select("*")->where("team_id", $user->team_id)->first();
        $teamPackage->delete();

        $mailgunService->saveAndSendEmail($user, "Payment has been rejected", view("/templates/sendSplitTheBillRejected", compact("user", "team")));

        $timeSent = new TimeSent();

        $userChat = UserChat::select("*")->where("receiver_user_id", $team->ceo_user_id)->where("creator_user_id", 1)->first();
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $timeSent->time;
        $userMessage->message = "The payment for your team has been rejected because one of your team members rejected the validation request.";
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();
    }

    public static function calculateNewPrice($oldPrice, $currentPrice){
        return $oldPrice + $currentPrice;
    }
}