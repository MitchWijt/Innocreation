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

class DebugController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function test(Request $request) {
//        if(Auth::attempt(['email'=>"mitchel@wijt.net",'password'=>"Dazzle45"])) {
//            $user = User::select("*")->where("email", "mitchel@wijt.net")->with("team")->first();
//            Session::set('user_name', $user->getName());
//            Session::set('user_role', $user->role);
//            Session::set('user_id', $user->id);
//            if ($user->role == 1) {
//                Session::set('admin_user_id', $user->id);
//            }
//            if ($user->team_id != NULL) {
//                Session::set('team_id', $user->team_id);
//                Session::set("team_name", $user->team->team_name);
//            }
//        }
        dd(Session::get("user_id"));
        die('test');
    }
}
