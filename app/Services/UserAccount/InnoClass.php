<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 12/01/2019
 * Time: 11:11
 */

namespace App\Services\UserAccount;


class InnoClass
{
    public $id;
    public $name;
    public $profile_pic;
    public $active_status;

    public function __construct(){
        $this->id = 1;
        $this->name = "Innocreation";
        $this->profile_pic = "/images/cartwheel.png";
        $this->active_status = null;
    }

    public function getProfilePicture(){
        return $this->profile_pic;
    }

    public function getName(){
        return $this->name;
    }

    public function getUrl(){
        return "/";
    }
}