<?php

namespace App\Http\Controllers;

use App\Country;
use App\Expertises;
use App\Expertises_linktable;
use App\MailMessage;
use App\NeededExpertiseLinktable;
use App\Team;
use App\User;
use App\UserChat;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterProcessController extends Controller {

    public function indexAction(Request $request){
        $title = "Create my account";
        $expertises = Expertises::select("*")->get();
        $countries = Country::select("*")->orderBy("country")->get();
        $email = $request->input("email");
        $existingUser = User::select("*")->where("email", $email)->first();
        if($existingUser){
            return redirect("/")->withErrors("We're sorry. There has already been a account registered with this email address");
        }
        $pageType = "checkout";
        if(Session::has("user_id")){
            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            if($user->getExpertises(true) != ""){
                $teamIdArray = [];
                $neededExpertises = NeededExpertiseLinktable::select("*")->where("amount", "!=", 0)->get();
                foreach($neededExpertises as $neededExpertise){
                    $expertiseLinktable = Expertises_linktable::select("*")->where("user_id", $user->id)->where("expertise_id", $neededExpertise->expertise_id)->first();
                    if ($expertiseLinktable) {
                        if($neededExpertise->teams->First()->allowedRequest()) {
                            array_push($teamIdArray, $neededExpertise->team_id);
                        }
                    }
                }
                $teams = Team::select("*")->whereIn("id", $teamIdArray)->limit(3)->get();
                return view("/public/registerProcess/index", compact("pageType", "email", "countries", "user", "expertises", "title", "teams"));
            } else {
                return view("/public/registerProcess/index", compact("pageType", "email", "countries", "user", "expertises", "title"));
            }
        } else {
            return view("/public/registerProcess/index", compact("pageType", "email", "countries", "expertises", "title"));
        }
    }

    public function saveUserCredentialsAction(Request $request){
        $firstname = $request->input("firstname");
        $middlename = $request->input("middlename");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $password = $request->input("password");
        $back = $request->input("back");

        if(Session::has('user_id')){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            $existingUser = User::select("*")->where("email", $request->input("email"))->first();
            if ($existingUser->email == $user->email || !$existingUser) {
                $user = User::select("*")->where("id", Session::get("user_id"))->first();
                $user->firstname = ucfirst($firstname);
                if ($request->input("middlename") != null || $request->input("middlename") != "") {
                    $user->middlename = $middlename;
                }
                $user->lastname = ucfirst($lastname);
                if($back != 1) {
                    $user->password = bcrypt($password);
                }
                $user->email = $email;
                if ($request->input("middlename") != null || $request->input("middlename") != "") {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($user->middlename = $request->input("middlename")) . strtolower($request->input("lastname")));
                } else {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($request->input("lastname")));
                }
                $user->created_at = date("Y-m-d H:i:s");
                $user->save();

                if($back != 1) {
                    $mgClient = $this->getService("mailgun");
                    $mgClient[0]->sendMessage($mgClient[1], array(
                        'from' => "Innocreation <info@innocreation.net>",
                        'to' => $user->email,
                        'subject' => "Welcome to Innocreation!",
                        'html' => view("/templates/sendWelcomeMail", compact("user"))
                    ), array(
                        'inline' => array($_SERVER['DOCUMENT_ROOT'] . '/images/cartwheel.png', $_SERVER['DOCUMENT_ROOT'] . '/images/icons/email.png')
                    ));
                    $mailMessage = new MailMessage();
                    $mailMessage->receiver_user_id = $user->id;
                    $mailMessage->subject = "Welcome to Innocreation!";
                    $mailMessage->message = view("/templates/sendWelcomeMail", compact("user"));
                    $mailMessage->created_at = date("Y-m-d");
                    $mailMessage->save();
                }

                return 1;
            } else {
                return 0;
            }
        } else {
            $existingUser = User::select("*")->where("email", $request->input("email"))->first();
            if (!$existingUser) {
                $user = New User();
                $user->role = 2;
                $user->firstname = ucfirst($firstname);
                if ($request->input("middlename") != null || $request->input("middlename") != "") {
                    $user->middlename = $middlename;
                }
                $user->lastname = ucfirst($lastname);
                $user->password = bcrypt($password);
                $user->email = $email;
                if ($request->input("middlename") != null || $request->input("middlename") != "") {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($user->middlename = $request->input("middlename")) . strtolower($request->input("lastname")));
                } else {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($request->input("lastname")));
                }
                $user->hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
                $user->profile_picture = "defaultProfilePicture.png";
                $user->created_at = date("Y-m-d H:i:s");
                $user->save();

                $client = $this->getService("stream");
                $streamFeed = $client->feed('user', $user->id);
                $token = $streamFeed->getToken();

                $mollie = $this->getService("mollie");
                $customer = $mollie->customers->create([
                    "name" => $user->getName(),
                    "email" => $user->email,
                ]);
                $newCustomer = User::select("*")->where("id", $user->id)->first();
                $newCustomer->mollie_customer_id = $customer->id;
                $newCustomer->stream_token = $token;
                $newCustomer->save();

                $userChat = new UserChat();
                $userChat->creator_user_id = 1;
                $userChat->receiver_user_id = $user->id;
                $userChat->created_at = date("Y-m-d H:i:s");
                $userChat->save();

                if (Auth::attempt(['email' => $request->input("email"), 'password' => $request->input("password")])) {
                    $user = User::select("*")->where("email", $request->input("email"))->first();
                    Session::set('user_name', $user->getName());
                    Session::set('user_role', $user->role);
                    Session::set('user_id', $user->id);
                }
                return 1;
            } else {
                return 0;
            }
        }
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

    public function saveUserExpertisesAction(Request $request){
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $expertisesAll = Expertises::select("*")->get();
        $existingArray = [];
        foreach ($expertisesAll as $existingExpertise) {
            array_push($existingArray, $existingExpertise->title);
        }

        $existingExpertises = Expertises_linktable::select("*")->where("user_id", $user->id)->get();
        $existingExpArray = [];
        foreach ($existingExpertises as $existingExpertise) {
            array_push($existingExpArray, $existingExpertise->expertise_id);
        }

        $chosenExpertisesString = $request->input("expertises");
        $chosenExpertises = explode(", ", $chosenExpertisesString);
        foreach ($chosenExpertises as $expertise) {
            if (!in_array(ucfirst($expertise), $existingArray)) {
                $newExpertise = New Expertises;
                $newExpertise->title = ucfirst($expertise);
                $newExpertise->slug = str_replace(" ", "-",strtolower($expertise));
                $newExpertise->save();

                $userExpertise = New expertises_linktable;
                $userExpertise->user_id = $user->id;
                $userExpertise->expertise_id = $newExpertise->id;
                $userExpertise->save();

            } else {
                $expertiseNewUser = Expertises::select("*")->where("title", $expertise)->first();
                if (!in_array($expertiseNewUser->id, $existingExpArray)) {
                    $userExpertise = New expertises_linktable;
                    $userExpertise->user_id = $user->id;
                    $userExpertise->expertise_id = $expertiseNewUser->id;
                    $userExpertise->save();
                }
            }
        }
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
