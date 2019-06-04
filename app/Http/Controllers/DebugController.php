<?php

namespace App\Http\Controllers;

use App\Payments;
use App\Services\AppServices\MailgunService;
use App\Services\AppServices\MollieService;
use App\Services\Payments\PaymentService;
use App\Services\TimeSent;
use App\SplitTheBillLinktable;
use App\Team;
use App\TeamPackage;
use App\TeamProjectTask;
use App\User;
use App\UserChat;
use App\UserMessage;
use Illuminate\Http\Request;
use Auth;
use Str;
use Session;

class DebugController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function test(Request $request, MailgunService $mailgunService) {
        $tasksArray = [];
        $allTasks = TeamProjectTask::select("*")->get();
        foreach($allTasks as $task){
            if($task->folder && $task->folder->team_project_id == 1){
                array_push($tasksArray, $task);
            }
        }

        dd($tasksArray);
        die('test');
    }
}
