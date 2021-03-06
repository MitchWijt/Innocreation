<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\UserChat;
use App\UserWork;
use Illuminate\Http\Request;
use Mailgun\Exception;
use Session;
use App\User;
use App\Http\Requests;
use App\ServiceReview;
use App\Services\Home\HomeService as homeService;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = "Collaborate with other creatives!";
        $og_description = "Create a team with like-minded people, help each other make dreams become a reality!";
        $carouselUserWorks = UserWork::select("*")->orderBy("created_at", "DESC")->limit(6)->get();
        $expertises = Expertises::select("*")->get();
        $limit = 7;
        $expertises1Array = [];
        $expertises1 = Expertises::select("*")->limit($limit)->inRandomOrder()->get();
        foreach($expertises1 as $exp1){
            array_push($expertises1Array, $exp1->id);
        }
        $expertises2 = Expertises::select("*")->whereNotIn("id", $expertises1Array)->limit($limit)->inRandomOrder()->get();

        if(Session::has("user_id")){
            $loggedIn = true;
        }

       return view("public/home/home", compact("title", "og_description", "carouselUserWorks", "loggedIn", 'expertises', 'expertises1', 'expertises2'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function footer(){
        return view("includes/footer");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactAction(){
        $title = "Ask your questions!";
        $og_description = "Ask all of your questions about Innocreation right here!";
        $serviceReviews = ServiceReview::select("*")->where("service_review_type_id", 1)->get();
        if($this->isLoggedIn()){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/home/contactUs", compact("user", "serviceReviews", "title", "og_description"));
        } else {
            return view("/public/home/contactUs", compact("serviceReviews", "title", "og_description"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendContactFormAction(Request $request){
        $firstname  = $request->input("firstname");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $message = $request->input("contactMessage");

        $data = array(
            'secret' => '6LfW7G4UAAAAAM1bLVc1WzYb37sbVoFogB8rByea',
            'response' =>  $request->input("g-recaptcha-response")
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $captcha_response = json_decode($server_output);
        if ($captcha_response->success == false) {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors("Captcha hasn't been filled in correctly");
        } else if ($captcha_response->success ==true) {
            $sender = [$firstname, $lastname, $email, $message];
            $html  = view("/templates/sendMailFromContactForm", compact("sender"));

            $mgClient = $this->getService("mailgun");
            $mgClient[0]->sendMessage($mgClient[1], array(
                'from' => $email,
                'to' => "info@innocreation.net",
                'subject' => "Contact form submit",
                'html' => $html
            ), array(
                'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png')
            ));

            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Successfully sent contact form");
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function headerMail()
    {
        return view("/templates/sendWelcomeMail");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendMoreInfoMailAction(Request $request){
        $email = $request->input("emailCustomer");
        if($email != "" || !empty($email)) {
            $mgClient = $this->getService("mailgun");
            $mgClient[0]->sendMessage($mgClient[1], array(
                'from' => 'Innocreation <info@innocreation.net>',
                'to' => $email,
                'subject' => "Detailed information Innocreation!",
                'html' => view("/templates/sendMoreInfoMail")
            ), array(
                'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png', $_SERVER['DOCUMENT_ROOT'] . '/images/icons/dashboard.png', $_SERVER['DOCUMENT_ROOT'] . '/images/icons/teamwork-icon.png', $_SERVER['DOCUMENT_ROOT'] . '/images/icons/workspace.png')
            ));
            return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Mail has been sent!");
        } else {
            return redirect($_SERVER["HTTP_REFERER"]);
        }
    }

    public function getModalCarouselUserAction(Request $request){
        $userId = $request->input("userId");
        $user = User::select("*")->where("id", "$userId")->first();
        return view("/public/home/shared/_carouselUserModal", compact("user"));
    }

    public function searchExpertiseAction(Request $request, homeService $homeService){
        return $homeService->searchExpertise($request);
    }
}
