<?php

namespace App\Http\Controllers;

use App\User;
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
            $startDate = $request->input("startDate");
            $endDate = $request->input("endDate");

            $users = User::all();
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=test.csv");
            header("Pragma: no-cache");
            header("Expires: 0");
            $output = "Amount created account, Amount with team, Amount with chats, Amount with portfolio, Amount shared work, Amount profile picture, ,\r\n";
            foreach($users as $worker){
                $output = $output . 10 .','. 20 .','. 30 .','. 40 .','. 50 .','. 60 .",\r\n";
            }
            echo trim($output,',');
            exit;
        }
    }
}
