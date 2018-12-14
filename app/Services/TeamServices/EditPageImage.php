<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 14/12/2018
 * Time: 19:14
 */

namespace App\Services\TeamServices;


use App\Team;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EditPageImage
{
    public function editBannerImage($request){
        $teamId = $request->input("team_id");
        $team = Team::select("*")->where("id", $teamId)->First();
        if($team->ceo_user_id != Session::get("user_id")){
            return redirect("/my-account")->withErrors("An error occured while changing your banner image.");
        }

        $file = $request->file("bannerImg");
        $size = $this->formatBytes($file->getSize());
        if($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
            $exists = Storage::disk('spaces')->exists("teams/" . $team->slug . "/banner/" . $filename);
            if (!$exists) {
                Storage::disk('spaces')->delete("teams/" . $team->slug . "/banner/" . $team->banner);
                Storage::disk('spaces')->put("teams/" . $team->slug . "/banner/" . $filename, file_get_contents($file->getRealPath()), "public");
            }
            $team->banner = $filename;
            $team->save();
            return redirect(sprintf('/team/%s',  $team->slug));
        } else {
            return redirect(sprintf('/team/%s', $team->slug))->withErrors("Image is too large. The max upload size is 8MB");
        }
    }

    public function formatBytes($bytes, $precision = 2) {
        $unit = ["B", "KB", "MB", "GB"];
        $exp = floor(log($bytes, 1024)) | 0;
        if($unit[$exp] == "MB") {
            return round($bytes / (pow(1024, $exp)), $precision);
        } else if($unit[$exp] == "KB"){
            return 6;
        } else if($unit[$exp] == "GB"){
            return 9;
        }
    }
}