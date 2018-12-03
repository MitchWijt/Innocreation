<?php

namespace App;
use App\Expertises_linktable;

use Faker\Provider\Payment;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;
use Mollie\Api\MollieApiClient;
use Symfony\Component\EventDispatcher\Tests\Service;

class User extends Authenticatable
{
    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function country(){
        return $this->hasOne("\App\Country", "id","country_id");
    }

    public function roles(){
        return $this->hasMany("\App\UserRole", "id","role");
    }

    public function getProfilePicture(){
        if($this->profile_picture != "defaultProfilePicture.png") {
            echo env("DO_SPACES_URL") . "/users/$this->slug/profilepicture/$this->profile_picture";
        } else {
            return "/images/profilePicturesUsers/defaultProfilePicture.png";
        }
    }

    public function getBanner(){
        if($this->banner != "defaultBanner.png") {
            echo env("DO_SPACES_URL") . "/users/$this->slug/banner/$this->banner";
        } else {
            return "/images/profilePicturesUsers/defaultProfilePicture.png";
        }
    }


    public function getName(){
        if($this->middlename != null){
            return $this->firstname . " " . $this->middlename . " " . $this->lastname;
        } else {
            return $this->firstname . " " . $this->lastname;
        }

    }

    public function getUrl(){
        return "/user/". $this->slug;
    }

    public function getExpertiseLinktable(){
        $expertiseLinktable = expertises_linktable::select("*")->where("user_id", $this->id)->get();
        return $expertiseLinktable;
    }

    public function getExpertises($temp = false){
        if($temp){
            $expertiseArray = "";
        } else {
            $expertiseArray = [];
        }
        $expertiseLinktable = expertises_linktable::select("*")->where("user_id", $this->id)->with("Expertises")->get();
        foreach($expertiseLinktable as $expertise){
            if($temp){
                if($expertiseArray == ""){
                    $expertiseArray = $expertise->expertises->First()->title;
                } else {
                    $expertiseArray = $expertiseArray . ", " . $expertise->expertises->First()->title;
                }
            } else {
                array_push($expertiseArray, $expertise->expertise_id);
            }
        }
        if(!$temp) {
            $expertises = Expertises::select("*")->whereIn("id", $expertiseArray)->get();
            return $expertises;
        } else {
            return $expertiseArray;
        }
    }

    public function getJoinedExpertise(){
        $expertise = JoinRequestLinktable::select("*")->where("user_id", $this->id)->where("accepted", 1)->first();
        if(!$expertise){
            $expertise = InviteRequestLinktable::select("*")->where("user_id", $this->id)->where("accepted", 1)->first();
        }
        return $expertise;
    }

    public function checkJoinRequests($expertise_id, $team_id){
        $bool = false;
        $joinRequests = JoinRequestLinktable::select("*")->where("expertise_id", $expertise_id)->where("team_id", $team_id)->where("user_id", $this->id)->where("accepted", 0)->get();
        if(count($joinRequests) > 0){
            $bool = true;
        }
        return $bool;
    }

    public function checkCustomerServiceReview($ticket_id){
        $bool = false;
        $serviceReview = ServiceReview::select("id")->where("ticket_id", $ticket_id)->where("user_id", $this->id)->get();
        if($serviceReview){
            $bool = true;
        }
        return $bool;
    }

    public function checkTeamProduct($team_product_id, $category){

        $bool = false;
        $teamProductLiketable = TeamProductLinktable::select("*")->where("team_product_id", $team_product_id)->where("user_id", $this->id)->where("$category", 1)->get();
        if(count($teamProductLiketable) > 0){
            $bool = true;
        }
        return $bool;
    }

    public function getAssistanceTickets(){
        $assistanceTickets = AssistanceTicket::select("*")->where("creator_user_id", $this->id)->get();
        return count($assistanceTickets);
    }

    public function getAssignedTasks(){
        $counter = 0;
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $this->id)->where("completed", 0)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if($short_term_planner_task->board->team_id == $this->team_id) {
                $counter++;
            }
        }
        return $counter;
    }

    public function getCompletedTasks(){
        $counter = 0;
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $this->id)->where("completed", 1)->get();
        foreach($short_term_planner_tasks as $short_term_planner_task){
            if($short_term_planner_task->board->team_id == $this->team_id) {
                $counter++;
            }
        }
        return $counter;
    }

    public function getAmountThreadPosts(){

        $forumThreads = ForumThread::select("*")->where("creator_user_id", $this->id)->get();
        return $forumThreads;

    }

    public function isMember(){
        $bool = false;
        if($this->team_id != null) {
            if ($this->team->split_the_bill == 1) {
                $bool = true;
            } else if ($this->team->split_the_bill == 0 && $this->id == $this->team->ceo_user_id) {
                $bool = true;
            } else {
                $bool = false;
            }
            if ($this->subscription_canceled == 0) {
                $bool = true;
            } else {
                $bool = false;
            }
            $payment = Payments::select("*")->where("user_id", $this->id)->get();
            if (count($payment) > 0) {
                $bool = true;
            } else {
                $bool = false;
            }
        } else {
            $bool = false;
        }

        return $bool;
    }

    public function getMostRecentPayment(){
        $payment = Payments::select("*")->where("user_id", $this->id)->where("payment_status", "paid")->orderBy("created_at", "DESC")->first();
        return $payment;

    }

    public function getMostRecentOpenPayment(){
        $payment = Payments::select("*")->where("user_id", $this->id)->where("payment_status", "Open")->orderBy("created_at", "DESC")->first();
        if($payment){
            return $payment;
        } else {
            return false;
        }


    }

    public function getSplitTheBill(){
        $splitTheBill = SplitTheBillLinktable::select("*")->where("user_id", $this->id)->where("team_id", $this->team_id)->first();
        return $splitTheBill;

    }

    public function hasValidSubscription(){
        $fullDomain = $_SERVER['HTTP_HOST'];
        $domainExplode = explode(".", $fullDomain);
        if($domainExplode[0] == "secret") {
            $apiKey = "test_5PW69PFKTaBS6E9A4Sgb3gzWjQ5k4v";
        } else {
            $apiKey = "live_BdmQNxeQ3zaQrqbmPepVSS33D3QVKe";
        }
        if($this->getMostRecentPayment()){
            if($this->getMostRecentPayment()->sub_id != null){
                $mollie = new MollieApiClient();
                $mollie->setApiKey($apiKey);

                $customer = $mollie->customers->get($this->mollie_customer_id);
                $subscription = $customer->getSubscription($this->getMostRecentPayment()->sub_id);
                if($subscription->status == "active"){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function paidSplitTheBill(){
        if($this->team_id != null){
            if($this->team->split_the_bill == 1){
                $splitTheBillLinktable = SplitTheBillLinktable::select("*")->where("user_id", $this->id)->where("team_id", $this->team_id)->first();
                $payment = Payments::select("*")->where("team_id", $this->team_id)->where("user_id", $this->id)->orderBy("created_at", "DESC")->first();
                if(date("Y-m", strtotime($payment->created_at)) == date("Y-m") && $payment->payment_status == "paid" && $splitTheBillLinktable->team_id == $this->team_id){
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function getSeoExpertises(){
        $expertiseLinktable = expertises_linktable::select("*")->where("user_id", $this->id)->get();
        if(count($expertiseLinktable) > 1){
            return $expertiseLinktable->First()->expertises->First()->title . " and more!";
        } else {
            return $expertiseLinktable->First()->expertises->First()->title;
        }
    }

    public function getPopoverView(){
        $expertises = $this->getExpertises();
        $user = $this;
        return view("/public/collaborateChat/shared/_popoverView", compact("expertises", "user"));
    }

    public function getPopoverViewUserWork(){
        $expertises = $this->getExpertises();
        $user = $this;
        return view("/public/userworkFeed/shared/_popoverView", compact("expertises", "user"));
    }

    public function getPasswordResetLink(){
        return "/resetPassword/$this->hash";
    }

    public function isActiveInExpertise($expertiseId){
        $userExpertiseLinktable = Expertises_linktable::select("*")->where("user_id", $this->id)->where("expertise_id", $expertiseId)->first();
        if($userExpertiseLinktable){
            return true;
        } else {
            return false;
        }
    }

    public function getSinglePortfolio(){
        $portfolio = UserPortfolio::select("*")->where("user_id", $this->id)->first();
        if($portfolio){
            return $portfolio;
        } else {
            return false;
        }
    }

    public function hasUpvote($userWorkId){
        $userUpvote = UserUpvoteLinktable::select("*")->where("user_id", $this->id)->where("user_work_id", $userWorkId)->get();
        if(count($userUpvote) > 0){
            return true;
        } else {
            return false;
        }
    }

    public function checkFollow($user_id){
        $userFollow = UserFollowLinktable::select("*")->where("user_id", Session::get("user_id"))->where("followed_user_id", $user_id)->get();
        if(count($userFollow) > 0){
            return true;
        } else {
            return false;
        }
    }

    public function hasContent(){
        $userPortflio = UserPortfolio::select("*")->where("user_id", $this->id)->get();
        $userWork = UserWork::select("*")->where("user_id", $this->id)->get();
        $bool = false;
        if(count($userWork) > 0 || count($userPortflio) > 0){
            $bool = true;
        }
        return $bool;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
