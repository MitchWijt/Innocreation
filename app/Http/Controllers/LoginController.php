<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\MailMessage;
use App\Team;
use App\UserChat;
use Faker\Provider\Payment;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Services\AppServices\UnsplashService as Unsplash;

use App\Http\Requests;
use App\User;
use App\Country;
use Auth;
use Session;
use App\InviteRequestLinktable;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hash = null, $teamName = null){
        if(request()->has('redirect_uri')){
            $redirectUri = request()->redirect_uri;
            $state = request()->state;
            $token = bin2hex(random_bytes(16));
            $url = $redirectUri . "#state=".$state. "&access_token=".$token."&token_type=Bearer";
        }
        $countries = Country::select("*")->orderBy("country")->get();
        $expertises = Expertises::select("*")->get();
        $pageType = "clean";
        if($hash != null && $teamName != null){
            $team = Team::select("*")->where("hash", $hash)->where("slug", $teamName)->first();
            $today2 = date("Y-m-d H:i:s", strtotime("+1 hour"));
            if(date("Y-m-d H:i:s", strtotime($team->timestamp)) <= $today2){
                Session::set("hash", $hash);
                Session::set("teamName", $teamName);
                $urlParameter = 1;
                return view("public/register/login", compact("countries", "expertises", "urlParameter", "pageType"));
            } else {
                $error = "This link has been expired. Ask the team for a new one to continue the invite";
                return view("public/register/login", compact("countries", "expertises", "pageType", "error"));
            }
        }
        if(!request()->has('redirect_uri')) {
            if (request()->has('register')) {
                $urlParameter = request()->register;
                return view("public/register/login", compact("countries", "expertises", "urlParameter", "pageType"));
            } else {
                return view("public/register/login", compact("countries", "expertises", "pageType"));
            }
        } else {
            if (request()->has('register')) {
                $urlParameter = request()->register;
                return view("public/register/login", compact("countries", "expertises", "urlParameter", "pageType", "url", "token"));
            } else {
                return view("public/register/login", compact("countries", "expertises", "pageType", "url", "token"));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $redirectUri = $request->input("redirect_uri");
        $token = $request->input("token");
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        $email = $request->get('email');
        $password = $request->get('password');
        if(Auth::attempt(['email'=>$email,'password'=>$password])) {
            $user = User::select("*")->where("email", $email)->with("team")->first();
            Session::set('user_name', $user->getName());
            Session::set('user_role', $user->role);
            Session::set('user_id', $user->id);
            if($user->role == 1) {
                Session::set('admin_user_id', $user->id);
            }
            if($user->team_id != null) {
                Session::set('team_id', $user->team_id);
                Session::set("team_name", $user->team->team_name);
            }

            if($user->stream_token == null){
                $client = $this->getService("stream");
                $streamFeed = $client->feed('user', $user->id);
                $streamToken = $streamFeed->getToken();
                $user->stream_token = $streamToken;
                $user->save();
            }

            if($user->country_id == null){
                return redirect("/create-my-account");
            } else if($user->country_id != null && $user->getExpertises(true) == ""){
                return redirect("/create-my-account");
            }

            if(!isset($redirectUri)){
                if ($request->input("pageType") && $request->input("pageType") == "checkout") {
                    return redirect($request->input("backlink"));
                } else {
                    return redirect($user->getUrl());
                }
            } else {
                $user->access_token = $token;
                $user->save();
                return redirect($redirectUri);
            }
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors('It seems that you have logged in with the wrong credentials. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $userId = Session::get("user_id");
        $user = User::select("*")->where("id", $userId)->first();
        $user->active_status = "offline";
        $user->save();
        
        Session::flush();
        return redirect("/");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
