<?php

namespace App\Http\Controllers;

use App\Expertises;
use App\Expertises_linktable;
use App\Team;
use App\UserChat;
use Faker\Provider\Payment;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;

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
    public function index($hash = null, $teamName = null)
    {
        $countries = Country::select("*")->orderBy("country")->get();
        $expertises = Expertises::select("*")->get();
        $pageType = "default";
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
        if(request()->has('register')){
            $urlParameter = request()->register;
            return view("public/register/login", compact("countries", "expertises", "urlParameter", "pageType"));

        } else {
            return view("public/register/login", compact("countries", "expertises", "pageType"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required',
            'email' => 'required',
            'expertises' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'country' => 'required',
            'phonenumber' => 'required',

        ]);
        $existingUser = User::select("*")->where("email", $request->input("email"))->first();
        if(!$existingUser) {
            $user = New User;
            $user->role = 2;
            $user->firstname = ucfirst($request->input("firstname"));
            if ($request->input("middlename") != null) {
                $user->middlename = $request->input("middlename");
            }
            $user->lastname = ucfirst($request->input("lastname"));
            $user->gender = $request->input("gender");
            $user->password = bcrypt(($request->input("password")));
            $user->email = $request->input("email");
            if ($request->input("middlename") != null) {
                $user->slug = strtolower($request->input("firstname")) . strtolower($user->middlename = $request->input("middlename")) . strtolower($request->input("lastname"));
            } else {
                $user->slug = strtolower($request->input("firstname")) . strtolower($request->input("lastname"));
            }
            $user->hash = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
            $user->city = $request->input("city");
            $user->postalcode = $request->input("postcode");
            $user->state = $request->input("state");
            $user->country_id = $request->input("country");
            $user->profile_picture = "defaultProfilePicture.png";
            $user->phonenumber = $request->input("phonenumber");
            $user->created_at = date("Y-m-d H:i:s");
            $user->save();


            $mollie = $this->getService("mollie");
            $customer = $mollie->customers->create([
                "name" => $user->getName(),
                "email" => $user->email,
            ]);
            $newCustomer = User::select("*")->where("id", $user->id)->first();
            $newCustomer->mollie_customer_id = $customer->id;
            $newCustomer->save();

            $userChat = new UserChat();
            $userChat->creator_user_id = 1;
            $userChat->receiver_user_id = $user->id;
            $userChat->created_at = date("Y-m-d H:i:s");
            $userChat->save();

            $expertisesAll = Expertises::select("*")->get();
            $existingArray = [];
            foreach ($expertisesAll as $existingExpertise) {
                array_push($existingArray, $existingExpertise->title);
            }

            $chosenExpertisesString = $request->input("expertises");
            $chosenExpertises = explode(", ", $chosenExpertisesString);
            foreach ($chosenExpertises as $expertise) {
                if (!in_array(ucfirst($expertise), $existingArray)) {
                    $newExpertise = New Expertises;
                    $newExpertise->title = ucfirst($expertise);
                    $newExpertise->save();

                    $userExpertise = New expertises_linktable;
                    $userExpertise->user_id = $user->id;
                    $userExpertise->expertise_id = $newExpertise->id;
                    $userExpertise->save();

                } else {
                    $expertiseNewUser = Expertises::select("*")->where("title", $expertise)->first();
                    $userExpertise = New expertises_linktable;
                    $userExpertise->user_id = $user->id;
                    $userExpertise->expertise_id = $expertiseNewUser->id;
                    $userExpertise->save();
                }
            }

            if(Session::has("hash") && Session::has("teamName")){
                $team = Team::select("*")->where("hash", Session::get("hash"))->where("team_name", Session::get("teamName"))->first();
                $user->team_id = $team->id;
                $user->save();

                $invite = new InviteRequestLinktable();
                $invite->team_id = $team->id;
                $invite->user_id = $user->id;
                $invite->expertise_id = $user->getExpertises()->first()->id;
                $invite->accepted = 1;
                $invite->created_at = date("Y-m-d");
                $invite->save();
            }
            if (Auth::attempt(['email' => $request->input("email"), 'password' => $request->input("password")])) {
                $user = User::select("*")->where("email", $request->input("email"))->first();
                Session::set('user_name', $user->getName());
                Session::set('user_role', $user->role);
                Session::set('user_id', $user->id);
                if ($user->team_id != null) {
                    Session::set('team_id', $user->team_id);
                    Session::set('team_name', $user->team->team_name);
                }
                Session::remove("hash");
                Session::remove("teamName");

                $this->saveAndSendEmail($user, 'Welcome to Innocreation!', view("/templates/sendWelcomeMail", compact("user")));

                if($request->input("pageType") && $request->input("pageType") == "checkout"){
                    return redirect($request->input("backlink"));
                } else {
                    return redirect("/account");
                }
            } else {
                return redirect($_SERVER["HTTP_REFERER"])->with('success', 'Account created');
            }
        } else {
            return redirect($_SERVER["HTTP_REFERER"])->withErrors( 'There has already been an account created with this email address.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
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
            if($request->input("pageType") && $request->input("pageType") == "checkout"){
                return redirect($request->input("backlink"));
            } else {
                return redirect("/account");
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
        Session::flush();
        return view("public/home/home");
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
