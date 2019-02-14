<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 02/11/2018
 * Time: 17:43
 */

namespace App\Services\UserAccount;


use App\User;
use Illuminate\Support\Facades\Session;

class UserPrivacySettingsService
{
    protected $user;

    public function __construct() {
        $user = User::select("*")->where("id", Session::get("user_id"))->first();
        $this->user = $user;
    }

    public function openSettingsModal(){
        $user = $this->user;
        return view("/public/user/shared/_userAccountPrivacySettingsModal", compact("user"));
    }
}