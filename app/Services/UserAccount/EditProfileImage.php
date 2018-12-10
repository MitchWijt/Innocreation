<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 09/12/2018
 * Time: 12:43
 */

namespace App\Services\UserAccount;


use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EditProfileImage
{
    public function editBannerImage($request){
        $userId = $request->input("user_id");
        if($userId != Session::get("user_id")){
            return redirect("/my-account")->withErrors("An error occured while changing your banner image.");
        }

        $user = User::select("*")->where("id", $userId)->first();
        $file = $request->file("bannerImg");
        $size = $this->formatBytes($file->getSize());
        if($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
            $exists = Storage::disk('spaces')->exists("users/" . $user->slug . "/banner/" . $filename);
            if (!$exists) {
                Storage::disk('spaces')->delete("users/" . $user->slug . "/banner/" . $user->banner);
                Storage::disk('spaces')->put("users/" . $user->slug . "/banner/" . $filename, file_get_contents($file->getRealPath()), "public");
            }
            $user->banner = $filename;
            $user->save();
            return redirect(sprintf('/user/%s', $user->slug));
        } else {
            return redirect(sprintf('/user/%s', $user->slug))->withErrors("Image is too large. The max upload size is 8MB");
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