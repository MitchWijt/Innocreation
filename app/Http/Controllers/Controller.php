<?php

namespace App\Http\Controllers;

use App\User;
use Redirect;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{

    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function isLoggedIn(){
        $bool = false;
        if(Session::has("user_id")){
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    public function authorized($admin = false){
        if($admin && $this->isLoggedIn()){
            $user = User::select("*")->where("id", Session::get("user_id"))->first();
            if(Session::get("user_role") == 1){
                return true;
            } else {
                redirect("/login")->withErrors("We're sorry, you don't have access to this part of the platform")->send();
            }
        } else {
            if($this->isLoggedIn()){
                return true;
            } else {
                redirect("/login")->withErrors("Your session has expired, please login again")->send();
            }
        }
    }

    public function getTimeSent(){
        $timeNow = date("H:i:s");
        $time = (date("g:i a", strtotime($timeNow)));
        return $time;
    }
}

    date_default_timezone_set("Europe/Amsterdam");
