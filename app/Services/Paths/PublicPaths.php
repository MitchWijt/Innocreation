<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 23/12/2018
 * Time: 10:13
 */
namespace App\Services\Paths;

class PublicPaths
{
    public static function userPortfolioPath($user, $portfolioDirName, $filename, $file, $uniqueId, $audio = false, $video = false){
        $portfolioDir = preg_replace('/[^a-zA-Z0-9-_\.]/', '', $portfolioDirName);
        if($audio){
            $audioDir = preg_replace('/[^a-zA-Z0-9-_\.]/','', str_replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName())) . $uniqueId . "-audio";
            $path = sprintf('users/%s/portfolios/%s/%s/%s',
                $user->slug,$portfolioDir,$audioDir, $filename
            );
            return $path;
        };
        if($video){
            $videoDir = preg_replace('/[^a-zA-Z0-9-_\.]/','', str_replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName())) . $uniqueId . "-video";
            $path = sprintf('users/%s/portfolios/%s/%s/%s',
                $user->slug,$portfolioDir,$videoDir, $filename
            );
            return $path;
        };
        $path = sprintf('users/%s/portfolios/%s/%s',
            $user->slug,$portfolioDir,$filename
        );

        return $path;
    }

    public static function getUserPortfolioFileDir($file, $uniqueId, $audio = false, $video = false){
        if($audio){
            $audioDir = preg_replace('/[^a-zA-Z0-9-_\.]/','', str_replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName())) . $uniqueId . "-audio";
            return $audioDir;
        };
        if($video){
            $videoDir = preg_replace('/[^a-zA-Z0-9-_\.]/','', str_replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName())) . $uniqueId . "-video";
            return $videoDir;
        }
    }

    public static function createUniqueid(){
        return uniqid();
    }

    public static function mimeType($audio = false, $video = false, $img = false){
        if($audio){
            return "audio/mpeg";
        }
        if($video){
            return "video/mp4";
        }
        if($img){
            return "image/jpeg";
        }
    }
}