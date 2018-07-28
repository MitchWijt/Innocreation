<?php

namespace App;
use App\Expertises_linktable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Symfony\Component\EventDispatcher\Tests\Service;

class User extends Authenticatable
{
    public function team(){
        return $this->hasOne("\App\Team", "id","team_id");
    }

    public function countries(){
        return $this->hasOne("\App\Country", "id","country_id");
    }

    public function roles(){
        return $this->hasMany("\App\UserRole", "id","role");
    }

    public function getProfilePicture(){
        return "/images/profilePicturesUsers/" . $this->profile_picture;
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

    public function getExpertises(){
        $expertiseArray = [];
        $expertiseLinktable = expertises_linktable::select("*")->where("user_id", $this->id)->with("Expertises")->get();
        foreach($expertiseLinktable as $expertise){
            array_push($expertiseArray, $expertise->expertise_id);
        }
        $expertises = Expertises::select("*")->whereIn("id", $expertiseArray)->get();
        return $expertises;
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
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $this->id)->where("completed", 0)->get();
        return count($short_term_planner_tasks);
    }

    public function getCompletedTasks(){
        $short_term_planner_tasks = WorkspaceShortTermPlannerTask::select("*")->where("assigned_to", $this->id)->where("completed", 1)->get();
        return count($short_term_planner_tasks);
    }

    public function getAmountThreadPosts(){

        $forumThreads = ForumThread::select("*")->where("creator_user_id", $this->id)->get();
        return $forumThreads;

    }

    public function isMember(){
        $bool = false;
        $payment = Payments::select("*")->where("user_id", $this->id)->get();
        if(count($payment) > 0){
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    public function getMostRecentPayment(){
        $payment = Payments::select("*")->where("user_id", $this->id)->where("payment_status", "Settled")->orderBy("created_at", "DESC")->first();
        return $payment;

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
