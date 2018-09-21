<?php

namespace App\Http\Controllers;

use App\Country;
use App\Expertises;
use App\MailMessage;
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
        $pageType = "checkout";
        if(Session::has("user_id")){
            $userId = Session::get("user_id");
            $user = User::select("*")->where("id", $userId)->first();
            return view("/public/registerProcess/index", compact("pageType", "email", "countries", "user", "expertises", "title"));
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
                $user->password = bcrypt($password);
                $user->email = $email;
                if ($request->input("middlename") != null || $request->input("middlename") != "") {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($user->middlename = $request->input("middlename")) . strtolower($request->input("lastname")));
                } else {
                    $user->slug = str_replace(" ", "-", strtolower($request->input("firstname")) . strtolower($request->input("lastname")));
                }
                $user->created_at = date("Y-m-d H:i:s");
                $user->save();
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


}
