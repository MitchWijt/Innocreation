<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 09/12/2018
 * Time: 16:18
 */

namespace App\Services\UserAccount;


use App\Services\Paths\PublicPaths;
use App\User;
use App\UserPortfolio;
use App\UserPortfolioFile;
use Faker\Provider\File;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\AppServices\FfmpegService as FfmpegService;

class UserAccountPortfolioService
{
    public function saveNewPortfolio($request, $ffmpegService, $ffprobeService){
        $user_id = $request->input("user_id");
        $portfolio_title = $request->input("portfolio_title");
        $files = $request->file("files");
        $user = User::select("*")->where("id", $user_id)->first();

        $userPortfolio = new UserPortfolio();
        $userPortfolio->user_id = $user_id;
        $userPortfolio->title = $portfolio_title;
        $userPortfolio->created_at = date("Y-m-d H:i:s");
        $userPortfolio->slug = preg_replace('/[^a-zA-Z0-9-_\.]/','', $portfolio_title);
        $userPortfolio->save();

        $dirname = preg_replace('/[^a-zA-Z0-9-_\.]/','', $portfolio_title);
        $uniqueId = uniqid();
        $this->addFileToPortoflio($files, $ffprobeService, $ffmpegService, $user, $dirname, $uniqueId, $userPortfolio);

        return redirect(sprintf('/my-account/portfolio/%s', $userPortfolio->slug));
    }

    public function portfolioDetailPage($slug){
        $userPortfolio = UserPortfolio::select("*")->where("slug", $slug)->first();
        if(Session::get("user_id") != $userPortfolio->user_id){
            return redirect("/my-account");
        }

        $userPortfolioFiles = UserPortfolioFile::select("*")->where("portfolio_id", $userPortfolio->id)->get();
        $user = User::select("*")->where("id", $userPortfolio->user_id)->first();
        return view("/public/user/portfolio/userAccountPortfolioDetail", compact('userPortfolioFiles', 'userPortfolio', 'user'));
    }

    public function addImagesPortfolio($request, $ffmpegService, $ffprobeService){
        $portfolioId = $request->input("portfolio_id");
        $userPortfolio = UserPortfolio::select("*")->where("id", $portfolioId)->first();
        $singleFile = UserPortfolioFile::select("*")->where("portfolio_id", $userPortfolio->id)->first();
        $uniqueId = PublicPaths::createUniqueid();
        if(Session::get("user_id") != $userPortfolio->user_id){
            return redirect("/my-account");
        }

        $user = User::select("*")->where("id", $request->input("user_id"))->first();

        $files = $request->file("files");
        $this->addFileToPortoflio($files, $ffprobeService, $ffmpegService, $user, $singleFile->dirname, $uniqueId, $userPortfolio);
        return redirect(sprintf('/my-account/portfolio/%s', $userPortfolio->slug));

    }

    public function addFileToPortoflio($files, $ffprobeService, $ffmpegService, $user, $singleFileDirName, $uniqueId, $userPortfolio){
        foreach($files as $file){
            $mimetype = $_FILES['files']['type'][0];
            if($mimetype == PublicPaths::mimeType(false, true, false)) {
                $size = $ffprobeService->getDuration($file);
                $condition = 30;
            } else {
                $size = $this->formatBytes($file->getSize());
                $condition = 8;
            }
            if($size < $condition) {
                $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
                if($mimetype == PublicPaths::mimeType(true, false, false)) {
                    $path = PublicPaths::userPortfolioPath($user, $singleFileDirName, $filename, $file, $uniqueId,true, false);
                    if (!Storage::disk('spaces')->has($path)) {
                        Storage::disk('spaces')->put($path, file_get_contents($file->getRealPath()), "public");
                    }
                } else if($mimetype == PublicPaths::mimeType(false, true, false)) {
                    $path = PublicPaths::userPortfolioPath($user, $singleFileDirName, $filename, $file, $uniqueId,false, true);
                    if (!Storage::disk('spaces')->has($path)) {
                        Storage::disk('spaces')->put($path, file_get_contents($file->getRealPath()), "public");
                    }
                } else {
                    $path = PublicPaths::userPortfolioPath($user, $singleFileDirName, $filename, $file, $uniqueId,false, false);
                    if (!Storage::disk('spaces')->has($path)) {
                        Storage::disk('spaces')->put($path, file_get_contents($file->getRealPath()), "public");
                    }
                }

                sleep(4);
                if (!Storage::disk('spaces')->has($path)) {
                    return redirect($user->getUrl())->withErrors("Something went wrong with your upload, please try again");
                }

                $userPortfolioFile = new UserPortfolioFile();
                $userPortfolioFile->portfolio_id = $userPortfolio->id;
                if($mimetype == PublicPaths::mimeType(true, false, false)) {
                    $userPortfolioFile->dirname_audio = PublicPaths::getUserPortfolioFileDir($file, $uniqueId, true, false);
                    $userPortfolioFile->audio = $filename;
                }
                if($mimetype == PublicPaths::mimeType(false, true, false)) {
                    $userPortfolioFile->dirname_video = PublicPaths::getUserPortfolioFileDir($file, $uniqueId, false, true);
                    $userPortfolioFile->video = $filename;
                }
                $userPortfolioFile->dirname = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $userPortfolio->title);
                if($mimetype != PublicPaths::mimeType(false, true, false) && $mimetype != PublicPaths::mimeType(true, false, false)) {
                    $userPortfolioFile->filename = $filename;
                }
                $userPortfolioFile->extension = $file->getClientOriginalExtension();
                $userPortfolioFile->mimetype = $mimetype;
                $userPortfolioFile->created_at = date("Y-m-d H:i:s");
                $userPortfolioFile->save();

                if($mimetype == PublicPaths::mimeType(false, true, false)){
                    $cdnDir = "users/$user->slug/portfolios/" . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $singleFileDirName) . "/" . PublicPaths::getUserPortfolioFileDir($file,$uniqueId, false, true);
                    $ffmpegService->extractThumbnailSaveToCdn($userPortfolioFile->getVideo(), $cdnDir, $filename . "-thumbnail");
                }

            } else {
                if($mimetype == PublicPaths::mimeType(false, true, false)) {
                    return redirect($user->getUrl())->withErrors("File is too large. The max upload duration per video is 20 seconds");
                }
                return redirect($user->getUrl())->withErrors("File is too large. The max upload size per image is 8MB");
            }
        }
    }

    public function editTitleImage($request){
        $fileId = $request->input("fileId");
        $title = $request->input("title");

        $file = UserPortfolioFile::select("*")->where("id", $fileId)->first();
        $file->title = $title;
        $file->save();
    }

    public function editDescImage($request){
        $fileId = $request->input("fileId");
        $description = $request->input("description");

        $file = UserPortfolioFile::select("*")->where("id", $fileId)->first();
        $file->description = $description;
        $file->save();
    }

    public function removeImage($request){
        $fileId = $request->input("file_id");
        $user = User::select("*")->where("id", $request->input("user_id"))->first();

        $file = UserPortfolioFile::select("*")->where("id", $fileId)->first();
        if($file->audio != null){
            Storage::disk('spaces')->delete("users/$user->slug/portfolios/$file->dirname/$file->dirname_audio/" . $file->audio);
        }
        if($file->dirname_audio != null && $file->audio != null && $file->filename != null){
            Storage::disk('spaces')->delete("users/$user->slug/portfolios/$file->dirname/$file->dirname_audio/" . $file->filename);
        }
        if($file->mimetype != PublicPaths::mimeType(true, false, false)) {
            Storage::disk('spaces')->delete("users/$user->slug/portfolios/$file->dirname/" . $file->filename);
        }
        $file->delete();
        return redirect(sprintf('/my-account/portfolio/%s', $file->portfolio->slug));
    }

    public function addImageToAudio($request){
        $fileId = $request->input("portfolio_file_id");
        $userId = $request->input("user_id");
        if(Session::get("user_id") != $userId){
            return redirect("/my-account");
        }
        $user = User::select("*")->where("id", $userId)->first();
        $file = $request->file("file");
        $size = $this->formatBytes($file->getSize());
        if($size < 8) {
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $file->getClientOriginalName());

            $userPortfolioFile = UserPortfolioFile::select("*")->where("id", $fileId)->first();
            $dirname = $userPortfolioFile->dirname;
            $dirname_audio = $userPortfolioFile->dirname_audio;

            if (!Storage::disk('spaces')->has("users/$user->slug/portfolios/" . $dirname . "/" . $dirname_audio . "/" . $filename)) {
                if($userPortfolioFile->filename != null) {
                    Storage::disk('spaces')->delete("users/$user->slug/portfolios/" . $dirname . "/" . $dirname_audio . "/" . $userPortfolioFile->filename);
                }
                Storage::disk('spaces')->put("users/$user->slug/portfolios/" . $dirname . "/" . $dirname_audio . "/" . $filename, file_get_contents($file->getRealPath()), "public");
                $userPortfolioFile->filename = $filename;
                $userPortfolioFile->save();
            }


        } else {
            return redirect($user->getUrl())->withErrors("Image is too large. The max upload size per image is 8MB");
        }

        return redirect(sprintf('/my-account/portfolio/%s', $userPortfolioFile->portfolio->slug));

    }

    public function deletePortfolio($request){
        $userId = $request->input("user_id");
        if($userId != Session::get("user_id")){
            return redirect("/my-account")->withErrors("You don't have permissions to do this");
        }

        $portfolioId = $request->input("portfolio_id");
        $userPortfolio = UserPortfolio::select("*")->where("id", $portfolioId)->first();
        $userPortfolioFiles = UserPortfolioFile::select("*")->where("portfolio_id", $portfolioId)->get();

        if($userPortfolioFiles) {
            foreach ($userPortfolioFiles as $userPortfolioFile) {
                if (Storage::disk('spaces')->has($userPortfolioFile->getPath())) {
                    Storage::disk('spaces')->delete($userPortfolioFile->getPath());
                    $userPortfolioFile->delete();
                }
            }
        }
        $userPortfolio->delete();

        return redirect('/my-account/portfolio');
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