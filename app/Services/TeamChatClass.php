<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 24/03/2019
     * Time: 09:32
     */

    namespace App\Services;


    use App\UserMessage;

    class TeamChatClass {
        public $id;
        public $name;
        public $profile_pic;
        public $active_status;

        public function __construct($team){
            $this->id = $team->id;
            $this->name = $team->team_name;
            $this->profile_pic = $team->getProfilePicture();
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

        public function getUnreadMessages($user_id){
            $userMessages = UserMessage::select('*')->where("team_id", $this->id)->where("sender_user_id", "!=", $user_id)->where("seen_at", null)->get();
            return count($userMessages);
        }
    }