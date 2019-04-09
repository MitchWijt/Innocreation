<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 27/03/2019
 * Time: 19:32
 */
namespace App\Services\Checkout;
use App\Team;
use App\User;
use Illuminate\Support\Facades\Session;

class SaveUserFromCheckout {

    public function saveUser($request){
        // gets userID and inputs given from form. Saves the user and if a new team has been created it creates a new team with the new user as Leader
        $userId = $request->input("user_id");
        $user = User::select("*")->where("id", $userId)->first();

        $firstname = $request->input("firstname");
        $middlename = $request->input("middlename");
        $lastname = $request->input("lastname");
        $email = $request->input("email");
        $country = $request->input("country");

        if ($request->input("team_name")) {
            self::saveTeam($request, $user);
        }

        $user->firstname = $firstname;
        $user->middlename = $middlename;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->country_id = $country;
        $user->save();

        return redirect($request->input("backlink") . "?step=2");
    }

    private static function saveTeam($request, $user){
        // creates a new team with new user as leader
        $team_name = $request->input("team_name");
        $all_teams = Team::select("*")->where("team_name", $team_name)->get();
        if (count($all_teams) != 0) {
            $error = "This name already exists";
            return view("/public/user/teamBenefits", compact("error", "user"));
        } else {
            $team = new Team;
            $team->team_name = ucfirst($team_name);
            $team->slug = str_replace(" ", "-", strtolower($team_name));
            $team->ceo_user_id = $user->id;
            $team->team_profile_picture = "defaultProfilePicture.png";
            $team->banner = "banner-default.jpg";
            $team->created_at = date("Y-m-d H:i:s");
            $team->save();

            $user->team_id = $team->id;
            $user->save();

            Session::set("team_id", $team->id);
            Session::set("team_name", $team->team_name);
        }
    }
}