<?php

namespace App\Http\Controllers;

use App\CustomerIdea;
use App\Expertises;
use App\Expertises_linktable;
use App\Faq;
use App\FaqType;
use App\FavoriteTeamLinktable;
use App\NeededExpertiseLinktable;
use App\ServiceReview;
use App\Services\FeedServices\SwitchUserWork;
use App\Services\UserAccount\UserAccount;
use App\Team;
use App\TeamReview;
use App\User;
use App\JoinRequestLinktable;
use App\Page;
use App\UserPortfolio;
use App\UserPortfolioFile;
use App\UserWork;
use Illuminate\Http\Request;
use Session;

use App\Http\Requests;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleTeamPageIndex(Request $request, $team_name)
    {
        // gets the team from the url team_name

        $acceptedJoinRequests = JoinRequestLinktable::select("*")->where("accepted", 1)->get();
        $acceptedExpertises = [];
        foreach($acceptedJoinRequests as $acceptedJoinRequest){
            array_push($acceptedExpertises, $acceptedJoinRequest->expertise_id);
        }
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $team = Team::select("*")->where("slug", $team_name)->first();
        $reviews = TeamReview::select("*")->where("team_id", $team->id)->get();
        if($user) {
            $favoriteTeam = FavoriteTeamLinktable::select("*")->where("team_id", $team->id)->where("user_id", $user->id)->first();
        }
        return view("/public/pages/singleTeamPage", compact("team","user", "acceptedExpertises", "favoriteTeam", "reviews"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function singleUserPageIndex($slug = null, SwitchUserWork $switchUserWork){
        if($slug){
            $user  = User::select("*")->where("slug", $slug)->first();
        }
        $loggedIn = UserAccount::isLoggedIn();
        $expertise_linktable = Expertises_linktable::select("*")->where("user_id", $user->id)->orderBy("created_at", "DESC")->get();
        $portfolios = UserPortfolio::select("*")->where("user_id", $user->id)->get();
        if($loggedIn) {
            $team = Team::select("*")->where("ceo_user_id", $loggedIn)->first();
        }

        $title = $user->firstname . " active as " . strtolower($user->getSeoExpertises());
        $activeAs = strtolower($user->getSeoExpertises());
        $validator = false;
        $og_description = "This is $user->firstname who is active as a $activeAs. Start working with each other! Create a team or join a team";
        $connections = $switchUserWork->listAcceptedConnections($user->id);

        $amountUserWorkPosts = UserWork::select("*")->where("user_id", $user->id)->count();
        return view("public/pages/singleUserPage", compact("user","expertise_linktable", "loggedIn", "portfolios","team", "neededExpertisesArray", "title", "og_description", "validator", "connections", "amountUserWorkPosts"));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pagesIndexAction($slug){
        $page = Page::select("*")->where("slug", $slug)->first();
        $title = $page->title;
        return view("/public/pages/pagesIndex", compact("page", "title"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function faqAction(){
        $faqTypes = FaqType::select("*")->get();
        return view("/public/pages/faq", compact("faqTypes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function platformIdeaAction(){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $customerIdeas = CustomerIdea::select("*")->where("user_id", Session::get("user_id"))->get();
        return view("/public/pages/customerIdea", compact("customerIdeas", "user"));
    }

    public function submitCustomerIdeaAction(Request $request){
        $userId = $request->input("user_id");
        $title = $request->input("idea_title");
        $idea = $request->input("idea");

        $customerIdea = new CustomerIdea();
        $customerIdea->user_id = $userId;
        $customerIdea->title = $title;
        $customerIdea->idea = $idea;
        $customerIdea->status = "On hold";
        $customerIdea->save();
        return redirect($_SERVER["HTTP_REFERER"])->with("success", "We thank you for your contribution on Innocreation!");
    }

    public function pagesAboutUsAction(){
        $title = "what is Innocreation?";

        $amountExpertises = Expertises::count();
        $expertiseLinktables = Expertises_linktable::select("*")->limit(3)->inRandomOrder()->get();
        return view("/public/pages/aboutUs", compact("title", "amountExpertises", "expertiseLinktables"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
