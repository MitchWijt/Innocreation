<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 17/04/2019
 * Time: 17:52
 */

namespace App\Services\TeamProject;

use Illuminate\Support\Facades\Session;

class TeamProjectService {
    public function index(){
        $userId = Session::get("user_id");
        $teamProjectApi = new TeamProjectApi();
        $projects  = $teamProjectApi->getProjects($userId);
        return view("/public/teamProjects/index", compact("projects"));
    }
}