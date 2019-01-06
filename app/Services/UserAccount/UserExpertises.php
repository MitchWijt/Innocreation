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
use App\Favorite_expertises_linktable;
use Illuminate\Support\Facades\Session;

class UserExpertises
{

    public function userAccountExpertisesIndex(){
        $user_id = Session::get("user_id");
        $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        $expertises = Expertises::select("*")->get();
        return view("/public/user/userAccountExpertises", compact("expertises_linktable", "user_id", "expertises"));
    }

    public function saveUserExpertiseDescription($request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $description = $request->input("userExpertiseDescription");

        $expertises = expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        $expertises->description = $description;
        $expertises->save();
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteUserExpertiseAction($request){
        $expertise_id = $request->input("expertise_id");
        $expertise_linktable = Expertises_linktable::select("*")->where("id", $expertise_id)->first();
        $expertise_linktable->delete();
        return 1;
    }

    public function addUserExpertiseAction($request, $unsplash){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise");
        $experience = $request->input("expertise_description");
        $newExpertise = ucfirst($request->input("newExpertises"));



        if(!$newExpertise) {
            $expertise_linktable = new expertises_linktable();
            $expertise_linktable->user_id = $user_id;
            $expertise_linktable->expertise_id = $expertise_id;
            $expertise_linktable->description = $experience;
            $expertise_linktable->save();

            $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
            $expertise_linktable->image = $imageObject->image;
            $expertise_linktable->photographer_name = $imageObject->photographer->name;
            $expertise_linktable->photographer_link = $imageObject->photographer->url;
            $expertise_linktable->image_link = $imageObject->image_link;
            $expertise_linktable->save();
        } else {
            $existingExpertise = Expertises::select("*")->where("title", $newExpertise)->first();
            if(count($existingExpertise) > 0){
                return redirect($_SERVER["HTTP_REFERER"])->withErrors("This expertise already seems to exist");
            } else {
                $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($newExpertise));
                $expertise = new Expertises();
                $expertise->title = $newExpertise;
                $expertise->image = $imageObject->image;
                $expertise->photographer_name = $imageObject->photographer->name;
                $expertise->photographer_link = $imageObject->photographer->url;
                $expertise->image_link = $imageObject->image_link;
                $expertise->slug = str_replace(" ", "-", strtolower($newExpertise));
                $expertise->save();

                $expertise_linktable = new expertises_linktable();
                $expertise_linktable->user_id = $user_id;
                $expertise_linktable->expertise_id = $expertise->id;
                $expertise_linktable->description = $experience;
                $expertise_linktable->save();

                $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
                $expertise_linktable->image = $imageObject->image;
                $expertise_linktable->photographer_name = $imageObject->photographer->name;
                $expertise_linktable->photographer_link = $imageObject->photographer->url;
                $expertise_linktable->image_link = $imageObject->image_link;
                $expertise_linktable->save();
                return redirect($_SERVER["HTTP_REFERER"])->withSuccess("Succesfully added $newExpertise as your expertise!");
            }
        }
        return redirect($_SERVER["HTTP_REFERER"]);
    }
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

    //Favorite Expetises user

    public function deleteFavoriteExpertisesUser($request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $favoriteExpertises = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        $favoriteExpertises->delete();
        return redirect('/my-account/favorite-expertises');
    }

    public function saveFavoriteExperisesUser($request){
        $user_id = $request->input("user_id");
        $expertise_id = $request->input("expertise_id");
        $existingFavExpertises = Favorite_expertises_linktable::select("*")->where("user_id",$user_id)->where("expertise_id", $expertise_id)->first();
        if (count($existingFavExpertises) == 0) {
            $favoriteExpertise = new Favorite_expertises_linktable;
            $favoriteExpertise->user_id = $user_id;
            $favoriteExpertise->expertise_id = $expertise_id;
            $favoriteExpertise->save();

            $AllFavUser = Favorite_expertises_linktable::select("*")->where("user_id", $user_id)->get();
            if(count($AllFavUser) >=4 ){
                return "max";
            }
            return $favoriteExpertise->expertise_id;
        }
    }
}