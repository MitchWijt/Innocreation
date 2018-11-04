<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 30/10/2018
 * Time: 18:35
 */
namespace App\Services\AdminServices;
use App\Expertises;
use App\Expertises_linktable;

class AdminExpertiseService
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

    public function randomImagesExpertises($unsplash){
        $expertises = Expertises::select("*")->get();
        foreach ($expertises as $expertise) {
            $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise->title));
            $expertise->image = $imageObject->image;
            $expertise->photographer_name = $imageObject->photographer->name;
            $expertise->photographer_link = $imageObject->photographer->url;
            $expertise->image_link = $imageObject->image_link;
            $expertise->save();
        }

        return redirect("/admin/expertiseList");
    }

    public function randomImagesExpertiseLinktables($unsplash){
        $expertise_linktables = Expertises_linktable::select("*")->get();
        foreach ($expertise_linktables as $expertiseLink) {
            $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertiseLink->expertises->First()->title));
            $expertiseLink->image = $imageObject->image;
            $expertiseLink->photographer_name = $imageObject->photographer->name;
            $expertiseLink->photographer_link = $imageObject->photographer->url;
            $expertiseLink->image_link = $imageObject->image_link;
            $expertiseLink->save();
        }

        return redirect("/admin/expertiseList");
    }
}