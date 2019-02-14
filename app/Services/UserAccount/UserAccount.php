<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 12/02/2019
 * Time: 19:44
 */

namespace App\Services\UserAccount;


use App\User;
use Illuminate\Support\Facades\Session;

class UserAccount {
    public static function isLoggedIn(){
        if(Session::has("user_id")){
            return Session::get("user_id");
        } else {
            return false;
        }
    }
}