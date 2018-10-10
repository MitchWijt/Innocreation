<?php

namespace App\Http\Controllers;

use App\User;
use App\UserChat;
use App\UserMessage;
use App\UserPortfolio;
use App\UserWork;
use Illuminate\Http\Request;

use App\Http\Requests;

class CommercialDataController extends Controller
{
    public function commercialDataIndexAction(){
        if($this->authorized(true)){
            return view("/admin/commercialdata/commercialDataIndex");
        }
    }

    public function exportDataCsvAction(Request $request){
        if($this->authorized(true)){
            $startDate =  date("Y-m-d H:i:s", strtotime($request->input("startDate")));
            $endDate = date("Y-m-d H:i:s", strtotime($request->input("endDate")));

            $accountWithChats = 0;
            $accountWithPortfolio = 0;
            $sharedWorks = 0;
            $allUsers = User::select("*")->get();
            foreach($allUsers as $user){

                $chat = UserMessage::select("*")->where("sender_user_id", $user->id)->whereBetween("created_at", array($startDate, $endDate))->get();
                if(count($chat) > 0){
                    $accountWithChats++;
                }

            }

            foreach($allUsers as $user){

                $portfolio = UserPortfolio::select("*")->where("user_id", $user->id)->whereBetween("created_at", array($startDate, $endDate))->get();
                if(count($portfolio) > 0){
                    $accountWithPortfolio++;
                }

            }

            foreach($allUsers as $user){

                $userWork = UserWork::select("*")->where("user_id", $user->id)->whereBetween("created_at", array($startDate, $endDate))->get();
                if(count($userWork) > 0){
                    $sharedWorks++;
                }

            }

            $createdAccount = User::select("*")->whereBetween("created_at", array($startDate, $endDate))->count();
            $AccountsWithTeam = User::select("*")->where("team_id", "!=", null)->whereBetween("created_at", array($startDate, $endDate))->count();
            $AccountsWithProfilePic = User::select("*")->where("profile_picture", "!=", "defaultProfilePicture.png")->whereBetween("created_at", array($startDate, $endDate))->count();

            
            $date1 = $request->input("startDate");
            $date2 = $request->input("endDate");
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=Data.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = "Start date, End date,\r\n $date1, $date2,\r\n Amount created account, Amount with team, Amount with chats, Amount with portfolio, Amount shared work, Amount profile picture, ,\r\n";
            $output = $output . $createdAccount .','. $AccountsWithTeam .','. $accountWithChats .','. $accountWithPortfolio .','. $sharedWorks .','. $AccountsWithProfilePic .",\r\n";
            echo trim($output,',');
            exit;
        }
    }
}
