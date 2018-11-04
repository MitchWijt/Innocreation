<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 29/10/2018
 * Time: 21:13
 */
namespace App\Services\UserAccount;
use App\Expertises;
use App\Expertises_linktable;
use Illuminate\Support\Facades\Session;

class UserExpertises
{
    public function getEditUserExpertiseModalImage($request, $unsplash){
        $expertiseId = $request->input("expertise_id");
        $expertise = Expertises::select("*")->where("id", $expertiseId)->first();
        $imageObjects = json_decode($unsplash->getListOfImages($expertise->title));

        return view("/public/user/shared/_editUserExpertiseImageModal", compact("expertise", "imageObjects"));
    }

    public function editUserExpertiseImage($request, $unsplash){
        $expertiseId = $request->input('expertise_id');
        $image = $request->input("image");
        $photographerName = $request->input("photographerName");
        $photographerLink = $request->input("photographerLink");
        $imgId = $request->input("imgId");

        $userId = Session::get("user_id");
        $expertiseLinktable = Expertises_linktable::select("*")->where("expertise_id", $expertiseId)->where("user_id", $userId)->first();
        $expertiseLinktable->image = $image;
        $expertiseLinktable->photographer_name = $photographerName;
        $expertiseLinktable->photographer_link = $photographerLink;
        $expertiseLinktable->save();

        $unsplash->downloadPhoto($imgId);

    }
}