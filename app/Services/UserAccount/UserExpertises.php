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
use App\Team;
use App\User;
use Illuminate\Support\Facades\Session;

class UserExpertises
{

    public function userAccountExpertisesIndex(){
        $user_id = Session::get("user_id");
        $expertises_linktable = expertises_linktable::select("*")->where("user_id", $user_id)->with("Users")->with("Expertises")->get();
        $expertises = Expertises::select("*")->get();
        return view("/public/user/userAccountExpertises", compact("expertises_linktable", "user_id", "expertises"));
    }

    public function saveUserExpertise($request, $unsplash){
        $user_id = $request->input("user_id");
        $description = $request->input("userExpertiseDescription");
        $skillLevelId = $request->input("skill_level_id");
        $expertise_id = $request->input("expertise_id");
        $newExpertiseTag = ucfirst($request->input("newExpertises"));
        $newExpertiseId =  $request->input("newExpertiseId");
        if(isset($expertise_id)){
            $expertise_linktable = Expertises_linktable::select("*")->where("user_id", $user_id)->where("expertise_id", $expertise_id)->first();
        } else {
            $expertise_linktable = new Expertises_linktable();
            $expertise_linktable->user_id = $user_id;

            if(!$newExpertiseTag){
                $expertise = Expertises::select("*")->where("id", $newExpertiseId)->first();
                $expertise_linktable->expertise_id = $expertise->id;
            } else {
                $existingExpertise = Expertises::select("*")->where("title", $newExpertiseTag)->first();
                if(count($existingExpertise) > 0){
                    return redirect($_SERVER["HTTP_REFERER"])->withErrors("This expertise already seems to exist");
                } else {
                    $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($newExpertiseTag));
                    $expertise = new Expertises();
                    $expertise->title = $newExpertiseTag;
                    $expertise->image = $imageObject->image;
                    $expertise->photographer_name = $imageObject->photographer->name;
                    $expertise->photographer_link = $imageObject->photographer->url;
                    $expertise->image_link = $imageObject->image_link;
                    $expertise->slug = str_replace(" ", "-", strtolower($newExpertiseTag));
                    $expertise->save();

                    $expertise_linktable->expertise_id = $expertise->id;

                    $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
                    $expertise_linktable->image = $imageObject->image;
                    $expertise_linktable->photographer_name = $imageObject->photographer->name;
                    $expertise_linktable->photographer_link = $imageObject->photographer->url;
                    $expertise_linktable->image_link = $imageObject->image_link;
                    $expertise_linktable->save();
                }
            }
        }
        $expertise_linktable->description = $description;
        $expertise_linktable->skill_level_id = $skillLevelId;
        $expertise_linktable->save();

        if(!$newExpertiseTag && !isset($expertise_id)){
            $imageObject = json_decode($unsplash->searchAndGetImageByKeyword($expertise_linktable->expertises->First()->title));
            $expertise_linktable->image = $imageObject->image;
            $expertise_linktable->photographer_name = $imageObject->photographer->name;
            $expertise_linktable->photographer_link = $imageObject->photographer->url;
            $expertise_linktable->image_link = $imageObject->image_link;
            $expertise_linktable->save();
        }
        return redirect($_SERVER["HTTP_REFERER"]);
    }

    public function deleteUserExpertiseAction($request){
        $expertise_id = $request->input("expertiseLinktableId");
        $expertise_linktable = Expertises_linktable::select("*")->where("id", $expertise_id)->first();
        $expertise_linktable->delete();
        return 1;
    }

    public function getEditUserExpertiseModalImage($request, $unsplash){
        $expertiseId = $request->input("expertise_id");
        $expertise = Expertises::select("*")->where("id", $expertiseId)->first();
        $imageObjects = json_decode($unsplash->getListOfImages($expertise->title));

        return view("/public/user/expertises/shared/_editUserExpertiseImageModal", compact("expertise", "imageObjects"));
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

    public function getEditExpertiseModal($request){
        $userId = Session::get("user_id");
        $user = User::select("*")->where("id", $userId)->first();
        $id = $request->input("expertiseLinktableId");
        $expertiseLinktable = Expertises_linktable::select("*")->where("id", $id)->first();
        if($expertiseLinktable){
            return view("/public/user/expertises/shared/_editExpertiseModal", compact("expertiseLinktable", "user"));
        } else {
            $expertises = Expertises::select("*")->get();
            return view("/public/user/expertises/shared/_editExpertiseModal", compact("user", "expertises"));
        }
    }

    public function loadMoreExpertises($request){
        $userId = $request->input("user_id");
        $user = User::select("*")->where("id", $userId)->first();

        $shownIds = [];
        $shownExpertises = Expertises_linktable::select("*")->where("user_id", $userId)->orderBy("created_at", "DESC")->limit(3)->get();
        foreach ($shownExpertises as $shownExpertise) {
            array_push($shownIds, $shownExpertise->id);
        }
        $loggedIn= UserAccount::isLoggedIn();
        if($loggedIn) {
            $team = Team::select("*")->where("ceo_user_id", $loggedIn)->first();
        }
        $expertise_linktable = Expertises_linktable::select("*")->where("user_id", $userId)->whereNotIn("id", $shownIds)->orderBy("created_at", "DESC")->get();
        return view("/public/user/expertises/shared/_moreExpertises", compact("expertise_linktable", "user", "loggedIn", "team"));

    }

    public static function skillLevels(){
        return array(
            array("id" => 1, 'color' => '#00C5DE', "level" => "beginner"),
            array("id" => 2, 'color' => '#FF6100', "level" => "intermediate"),
            array("id" => 3, 'color' => '#FF0000', "level" => "master")
        );
    }

    public static function getSkillLevel($skillId){
        $skills = self::skillLevels();
        foreach($skills as $skill){
            if($skill['id'] == $skillId){
                return $skill;
            }
        }
    }
}