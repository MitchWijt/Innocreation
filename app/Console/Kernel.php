<?php

namespace App\Console;

use App\Payments;
use App\Team;
use App\TeamPackage;
use App\CustomTeamPackage;
use App\User;
use App\SplitTheBillLinktable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $users = User::select("*")->where("subscription_canceled", 0)->get();
            foreach($users as $user){
                if($user->isMember()) {
                    $payment = $user->getMostRecentPayment();
                    $nextMonth = date("Y-m-d", strtotime($payment->created_at . "+1 month"));
                    $today = date("Y-m-d");
                    if ($today == $nextMonth) {
                        $referenceObject = Payments::select("*")->orderBy("id", "DESC")->first();
                        $reference = $referenceObject->reference + 1;

                        $teamPackage = TeamPackage::select("*")->where("team_id", $payment->team_id)->first();
                        $price = str_replace(".", "", number_format($teamPackage->price, 2, ".", "."));
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
                        if (isset($resultAuthorization->resultCode)) {
                            $resultCode = $resultAuthorization->resultCode;
                        }
                        $pspReference = $resultAuthorization->pspReference;
                        //close connection
                        curl_close($ch);
                        if ($resultCode != "Authorized" && !isset($resultAuthorization->resultCode)) {
                            $status = "Canceled";
                        } else {
                            $status = "Settled";
                        }
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
                        if ($resultCode != "Authorized" || !isset($resultCode)) {
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

                            $payment->payment_status = "Canceled";
                            $payment->save();

                            $user->payment_refused = 1;
                            $user->save();
                            $this->saveAndSendEmail($payment->user, "Payment refused", view("/templates/sendRecurringRefused", compact("user", "team")));
                        }
                        $newPayment = new Payments();
                        $newPayment->user_id = $user->id;
                        $newPayment->team_id = $user->team_id;
                        $newPayment->amount = $price;
                        $newPayment->recurring_detail_reference = $recurringDetailReference;
                        $newPayment->shopper_reference = $user->getName() . $user->team_id;
                        $newPayment->reference = $reference;
                        $newPayment->pspReference = $pspReference;
                        $newPayment->payment_status = $status;
                        $newPayment->created_at = date("Y-m-d H:i:s");
                        $newPayment->save();
                    }
                }
            }
        })->dailyAt("13:00");
    }
}
