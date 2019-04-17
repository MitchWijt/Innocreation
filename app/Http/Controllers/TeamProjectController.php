<?php

namespace App\Http\Controllers;

use App\Services\TeamProject\TeamProjectService;
use App\Services\TeamServices\TeamExpertisesService;
use Illuminate\Http\Request;

use App\Http\Requests;

class TeamProjectController extends Controller
{
    public function indexAction(){
        $teamProjectService = new TeamProjectService();

        $teamProjectService->index();
    }
}
