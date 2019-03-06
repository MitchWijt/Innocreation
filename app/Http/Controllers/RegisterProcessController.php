<?php

namespace App\Http\Controllers;

use App\Country;
use App\Expertises;
use App\Expertises_linktable;
use App\MailMessage;
use App\NeededExpertiseLinktable;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\MollieService;
use App\Services\AppServices\StreamService;
use App\Services\TimeSent;
use App\Services\UserAccount\RegisterUserService;
use App\Team;
use App\User;
use App\UserChat;
use App\UserMessage;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use App\Services\AppServices\UnsplashService as Unsplash;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterProcessController extends Controller {

    public function indexAction(Request $request){
        if(Session::has("user_id")){
            return redirect("/");
        }
        $title = "Create my account";
        $expertises = Expertises::select("*")->get();
        $countries = Country::select("*")->orderBy("country")->get();
        $pageType = "clean";
        return view("/public/register/register", compact("pageType", "email", "countries", "expertises", "title"));
    }

    public function saveUserCredentialsAction(Request $request, RegisterUserService $registerUserService){

        return $registerUserService->saveUserCredentials($request);
    }

    public function saveUserResidenceAction(Request $request){
        $city = $request->input("city");
        $postalcode = $request->input("postalcode");
        if($request->input("phonenumber") != ""){
            $phonenumber = $request->input("phonenumber");
        }
        $countryId = $request->input("countryId");

        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $user->country_id = $countryId;
        $user->city = $city;
        $user->postalcode = $postalcode;
        if(isset($phonenumber)){
            $user->phonenumber = $phonenumber;
        }
        $user->save();
        return 1;

    }

    public function saveUserTextsAction(Request $request){
        $introduction = $request->input("introduction");
        $motivation = $request->input("motivation");

        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $user->introduction = $introduction;
        $user->motivation = $motivation;
        $user->save();
        return 1;
    }


}
