<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;
use App\Http\Requests;
use App\ServiceReview;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = "Make your dreams become a reality!";
        $og_description = "Create a team with like-minded people, help each other make dreams become a reality!";
//        Session::flush();
       return view("public/home/home", compact("title", "og_description"));
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
}
