<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\UserConnections\ConnectionService as ConnectionService;
use App\Services\FeedServices\SwitchUserWork as SwitchUserWork;
class UserConnectionController extends Controller
{
    public function connectionsModalAction(Request $request, ConnectionService $connectionService, SwitchUserWork $switchUserWork){
        return $connectionService->connectionModal($request, $switchUserWork);
    }
}
