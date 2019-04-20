<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 20/04/2019
 * Time: 16:49
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class TeamProjectFolder extends Model {
    public $table = "team_project_folder";

    public function teamProject(){
        return $this->hasOne("\App\TeamProject", "id","team_project_id");
    }

}