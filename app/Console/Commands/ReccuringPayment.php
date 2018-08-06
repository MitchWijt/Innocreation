<?php

namespace App\Console\Commands;

use App\Invoice;
use App\MailMessage;
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
        $users = User::select("*")->where("subscription_canceled", 0)->get();
        foreach($users as $user){
            $team = Team::select("*")->where("id", $user->team_id)->first();
            $siteSetting = SiteSetting::select("*")->where("id", 1)->first();
            $siteSetting->published = $siteSetting->published + 1;
            $siteSetting->save();
            if($user->isMember()) {
                if(($user->getSplitTheBill() && $user->getSplitTheBill()->accepted == 1) || !$user->getSplitTheBill()) {
                    $payment = $user->getMostRecentPayment();
                    $today = date("Y-m-d");
                    $teamPackage = TeamPackage::select("*")->where("team_id", $payment->team_id)->first();
                    if($teamPackage->payment_preference == "monthly"){
                        $lastPaymentDate = date("Y-m-d", strtotime($payment->created_at . "+1 month"));
                    } else {
                        $lastPaymentDate = date("Y-m-d", strtotime($payment->created_at . "+1 year"));
                    }
//                    if ($today == $lastPaymentDate) {
                    $referenceObject = Payments::select("*")->orderBy("id", "DESC")->first();
                    $reference = $referenceObject->reference + 1;

                    if ($team->split_the_bill == 0) {
                        $price = str_replace(".", "", number_format($teamPackage->price, 2, ".", "."));
                    } else if ($teamPackage->change_package == 0) {
                        $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $team->id)->first();
                        $price = str_replace(".", "", number_format($splitTheBillLinktable->amount, 2, ".", "."));
                    } else {
                        $price = $payment->amount;
                    }
                    $data = array("amount" => array("value" => $price, "currency" => "EUR"), "reference" => $reference, "merchantAccount" => "InnocreationNET", "shopperReference" => $user->getName() . $user->team->id, "selectedRecurringDetailReference" => $payment->recurring_detail_reference, "recurring" => array("contract" => "RECURRING"), "shopperInteraction" => "ContAuth");
                    $data_string = json_encode($data);

                    $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/authorise');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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
                    $resultAuthorization = json_decode($result);
                    if (isset($resultAuthorization->errorType)) {
                        $status = "Refused";

                        $user->payment_refused = 1;
                        $user->save();
//                        $this->saveAndSendEmail($payment->user, "Payment refused", view("/templates/sendRecurringRefused", compact("user", "team")));
                    } else if (isset($resultAuthorization->resultcode) && $resultAuthorization->resultcode == "Refused") {
                        $status = "Canceled";
                    } else {
                        $status = "Settled";
                    }
                    if(isset($resultAuthorization->pspReference)){
                        $pspReference = $resultAuthorization->pspReference;
                    }
                    //close connection
                    curl_close($ch);
                    //DETAILSRECURRING
                    $data = array("merchantAccount" => "InnocreationNET", "shopperReference" => $user->getName() . $user->team->id);
                    $data_string = json_encode($data);

                    $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Recurring/v25/listRecurringDetails');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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
                    $resultAuthorization = json_decode($result);

                    $recurringDetailReference = $resultAuthorization->details[0]->RecurringDetail->recurringDetailReference;

                    //close connection
                    curl_close($ch);

                    // create Invoice
                    if ($status == "Canceled") {
                        $data = array("merchantAccount" => "InnocreationNET", "originalReference" => $pspReference);
                        $data_string = json_encode($data);

                        $ch = curl_init('https://pal-test.adyen.com/pal/servlet/Payment/v30/cancel');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                'Authorization: Basic ' . base64_encode("ws@Company.Innocreation:[puCnJ5TjHjTxjpa++rI1%UD~"),
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
                        $resultAuthorization = json_decode($result);
                        //close connection
                        curl_close($ch);

                        $recentPayment = Payments::select("*")->where("id", $payment->id)->first();
                        $recentPayment->payment_status = "Refused(wrong details)";
                        $recentPayment->save();

                        $user->payment_refused = 1;
                        $user->save();
                        $this->saveAndSendEmail($payment->user, "Payment refused", view("/templates/sendRecurringRefused", compact("user", "team")));
                    }
                    if($status == "Settled"){
                        $invoiceNumber = Invoice::select("*")->orderBy("invoice_number", "DESC")->first()->invoice_number;

                        $invoice = new Invoice();
                        $invoice->user_id = $user->id;
                        $invoice->team_id = $team->id;
                        $invoice->team_package_id = $teamPackage->id;
                        if($team->split_the_bill == 1){
                            $invoice->amount = $splitTheBillLinktable->amount;
                        } else {
                            $invoice->amount = number_format($teamPackage->price, 2, ".", ".");
                        }
                        $invoice->hash = $user->hash;
                        $invoice->invoice_number = $invoiceNumber + 1;
                        $invoice->paid_date = date("Y-m-d", strtotime("+2 days"));
                        $invoice->created_at = date("Y-m-d H:i:s");
                        $invoice->save();

                    }
                    $details = end($resultAuthorization->details);
                    $card = $details->RecurringDetail->card;
                    $paymentMethod = $details->RecurringDetail->paymentMethodVariant;
                    $newPayment = new Payments();
                    $newPayment->user_id = $user->id;
                    $newPayment->team_id = $user->team_id;
                    $newPayment->payment_method = $paymentMethod;
                    $newPayment->card_number = $card->number;
                    $newPayment->amount = $price;
                    $newPayment->recurring_detail_reference = $recurringDetailReference;
                    $newPayment->shopper_reference = $user->getName() . $user->team_id;
                    $newPayment->reference = $reference;
                    if(isset($resultAuthorization->pspReference)){
                        $newPayment->pspReference = $pspReference;
                    }
                    $newPayment->payment_status = $status;
                    $newPayment->created_at = date("Y-m-d H:i:s");
                    $newPayment->save();
//                    }
                }
            }
        }
    }
}