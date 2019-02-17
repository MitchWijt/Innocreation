<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 09/12/2018
 * Time: 12:43
 */

namespace App\Services\UserAccount;


use App\Services\Images\ImageProcessor;
use App\Services\Paths\PublicPaths;
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

    public function editProfilePicture($request){
        $user_id = $request->input("user_id");
        $file = $request->file("profile_picture");
        $size = $this->formatBytes($file->getSize());
        $user = User::select("*")->where("id", $user_id)->first();
        if($size < 8) {
            $uniqueId = uniqid($user_id);
            $filename = PublicPaths::getFileName($uniqueId, $file, false, false);
            $filePath = $file->getRealPath();
            $targets = ["extra-small", "small", "normal", "large"];

            $imageProcessor = new ImageProcessor();
            $images = $imageProcessor->resize($file, $filePath, $targets, $uniqueId);
            foreach($images as $image){
                $uploadPath = PublicPaths::getUserProfilePicturePath($image['filename'], $user);
                $exists = Storage::disk('spaces')->exists($uploadPath);
                if (!$exists) {
                    foreach($targets as $target){
                        $pathDelete = $user->getProfilePicture($target, true);
                        Storage::disk('spaces')->delete($pathDelete);
                    }
                }
                $imageProcessor->upload($image['file'], $uploadPath, true);
            }

            $user->profile_picture = $filename;
            $user->extension = $file->getClientOriginalExtension();
            $user->save();
            return redirect($_SERVER["HTTP_REFERER"]);
        } else {
            return redirect($user->getUrl())->withErrors("Image is too large. The max upload size is 8MB");
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