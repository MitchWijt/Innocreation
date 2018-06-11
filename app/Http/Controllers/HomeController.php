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
    public function index()
    {
//        Session::flush();
       return view("public/home/home");
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
        $serviceReviews = ServiceReview::select("*")->where("service_review_type_id", 1)->get();
        if($this->isLoggedIn()){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            return view("/public/home/contactUs", compact("user", "serviceReviews"));
        } else {
            return view("/public/home/contactUs", compact("serviceReviews"));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendContactFormAction(Request $request){
        die("Email todo and live server for email");
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
    public function destroy($id)
    {
        //
    }
}
