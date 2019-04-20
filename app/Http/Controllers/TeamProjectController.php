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
        return $teamProjectService->index();
    }

    // Returns a shared_view in the sidebar for all the folders and tasks of the project.
    public function getFoldersAndTasksProject(Request $request){
        $teamProjectService = new TeamProjectService();
        return $teamProjectService->getFoldersAndTasksView($request);
    }

    // sends a request with the teams project slug to the teamprojectService to return the planner page
    public function teamProjectPlannerAction($slug){
        $teamProjectService = new TeamProjectService();
        return $teamProjectService->teamProjectPlannerIndex($slug);
    }
}
