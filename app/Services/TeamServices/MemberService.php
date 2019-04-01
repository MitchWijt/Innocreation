<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 01/04/2019
 * Time: 18:37
 */

namespace App\Services\TeamServices;


use App\NeededExpertiseLinktable;
use App\Services\AppServices\MollieService;
use App\Services\Payments\PaymentService;
use App\Services\TimeSent;
use App\SplitTheBillLinktable;
use App\Team;
use App\User;
use App\UserChat;
use App\UserMessage;

class MemberService {

    public function kickMemberFromTeam($request){
        $user_id = $request->input("user_id");
        $team_id = $request->input("team_id");
        $mollie = new MollieService();

        $team = Team::select("*")->where("id", $team_id)->first();

        $user = User::select("*")->where("id", $user_id)->first();
        $userExpertises = $user->getExpertises();

        //checks if user had any expertises related to the teams needed expertises and refills the amount the team needs.
        self::refillNeededExpertisesTeam($team, $userExpertises);
        $user = User::select("*")->where("id", $user_id)->first();
        $user->team_id = null;
        $user->save();

        if($team->split_the_bill == 1 && $user->getMostRecentPayment()){
            $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $user->id)->where("team_id", $team->id)->first();
            if($splitTheBillLinktable) {

                // Calculates new price for the team leader + deletes the linktable of member.
                $teamLeaderSplitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $team->ceo_user_id)->where("team_id", $team->id)->first();
                $newLeaderPrice = PaymentService::calculateNewPrice($splitTheBillLinktable->amount, $teamLeaderSplitTheBillLinktable->amount);
                $splitTheBillLinktable->delete();

                $mollie->changePackageOfCustomer($team, $newLeaderPrice);

                $teamLeaderSplitTheBillLinktable->amount = $newLeaderPrice;
                $teamLeaderSplitTheBillLinktable->save();
            }

            //cancels user subscription in team package
            $mollie->cancelSubscription($user);

            $user->subscription_canceled = 1;
            $user->save();
        }

        $timeSent = new TimeSent();
        $userChat = UserChat::select("*")->where("receiver_user_id", $user->id)->where("creator_user_id", 1)->first();
        $userMessage = new UserMessage();
        $userMessage->sender_user_id = 1;
        $userMessage->user_chat_id = $userChat->id;
        $userMessage->time_sent = $timeSent->time;
        $userMessage->message = "We are sorry to say that $team->team_name has decided to kick you from their team.";
        $userMessage->created_at = date("Y-m-d H:i:s");
        $userMessage->save();

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public static function refillNeededExpertisesTeam($team, $expertises){
        foreach($expertises as $userExpertise) {
            $neededExpertise = NeededExpertiseLinktable::select("*")->where("team_id", $team->id)->where("expertise_id", $userExpertise->id)->first();
            if($neededExpertise) {
                $neededExpertise->amount = $neededExpertise->amount + 1;
                $neededExpertise->save();
            }
        }
    }
}