<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 09/12/2018
 * Time: 16:18
 */

namespace App\Services\UserAccount;


use App\User;
use App\UserPortfolio;
use App\UserPortfolioFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserAccountPortfolioService
{
    public function saveNewPortfolio($request){
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

        foreach($files as $file){
            $size = $this->formatBytes($file->getSize());
            if($size < 8) {
                $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
                Storage::disk('spaces')->put("users/$user->slug/portfolios/" . preg_replace('/[^a-zA-Z0-9-_\.]/','', $portfolio_title) . "/" . $filename, file_get_contents($file->getRealPath()), "public");

                $userPortfolioFile = new UserPortfolioFile();
                $userPortfolioFile->portfolio_id = $userPortfolio->id;
                $userPortfolioFile->dirname = preg_replace('/[^a-zA-Z0-9-_\.]/','', $portfolio_title);
                $userPortfolioFile->filename = $filename;
                $userPortfolioFile->extension = $file->getClientOriginalExtension();
                $userPortfolioFile->mimetype = $file->getMimetype();
                $userPortfolioFile->created_at = date("Y-m-d H:i:s");
                $userPortfolioFile->save();
            } else {
                return redirect("/account")->withErrors("Image is too large. The max upload size per image is 8MB");
            }
        }
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

    public function addImagesPortfolio($request){
        $portfolioId = $request->input("portfolio_id");
        $userPortfolio = UserPortfolio::select("*")->where("id", $portfolioId)->first();
        $singleFile = UserPortfolioFile::select("*")->where("portfolio_id", $userPortfolio->id)->first();
        if(Session::get("user_id") != $userPortfolio->user_id){
            return redirect("/my-account");
        }

        $user = User::select("*")->where("id", $request->input("user_id"))->first();

        $files = $request->file("files");
        foreach($files as $file){
            $size = $this->formatBytes($file->getSize());
            if($size < 8) {
                $filename = preg_replace('/[^a-zA-Z0-9-_\.]/','', $file->getClientOriginalName());
                if(!Storage::disk('spaces')->has("users/$user->slug/portfolios/" . preg_replace('/[^a-zA-Z0-9-_\.]/','', $singleFile->dir) . "/" . $filename)) {
                    Storage::disk('spaces')->put("users/$user->slug/portfolios/" . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $singleFile->dir) . "/" . $filename, file_get_contents($file->getRealPath()), "public");
                    $userPortfolioFile = new UserPortfolioFile();
                    $userPortfolioFile->portfolio_id = $userPortfolio->id;
                    $userPortfolioFile->dirname = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $userPortfolio->title);
                    $userPortfolioFile->filename = $filename;
                    $userPortfolioFile->extension = $file->getClientOriginalExtension();
                    $userPortfolioFile->mimetype = $file->getMimetype();
                    $userPortfolioFile->created_at = date("Y-m-d H:i:s");
                    $userPortfolioFile->save();
                }
            } else {
                return redirect("/account")->withErrors("Image is too large. The max upload size per image is 8MB");
            }
        }
        return redirect(sprintf('/my-account/portfolio/%s', $userPortfolio->slug));

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
        Storage::disk('spaces')->delete("users/$user->slug/portfolios/$file->dirname/" . $file->filename);
        $file->delete();
        return redirect(sprintf('/my-account/portfolio/%s', $file->portfolio->slug));
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