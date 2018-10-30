<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 30/10/2018
 * Time: 18:35
 */
namespace App\Services\AdminServices;
use App\Expertises;

class AdminExpertiseEditorService
{
    public function editExpertiseImage($request){
        $expertiseId = $request->input('expertise_id');
        $image = $request->input("image");
        $photographerName = $request->input("photographerName");
        $photographerLink = $request->input("photographerLink");

        $expertise = Expertises::select("*")->where("id", $expertiseId)->first();
        $expertise->photographer_name = $photographerName;
        $expertise->photographer_link = $photographerLink;
        $expertise->image = $image;
        $expertise->save();
    }
}