<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 29/03/2019
 * Time: 13:50
 */

namespace App\Services\Payments;


use App\Payments;

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
}