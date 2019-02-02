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
    /**
     * Returns the filename without spaces and weird characters based on the uploaded filename
     */
    public static function getFileName($uniqueId, $file, $placeholder = false, $extension = true){

        if($placeholder){
            if($extension){
                $name = sprintf('%s-%s.%s', preg_replace('/[^a-zA-Z0-9-_\.]/', '', $uniqueId), "placeholder", $file->getClientOriginalExtension());
            } else {
                $name = sprintf('%s-%s', preg_replace('/[^a-zA-Z0-9-_\.]/', '', $uniqueId), "placeholder");
            }
        } else {
            if($extension){
                $name = sprintf('%s.%s', preg_replace('/[^a-zA-Z0-9-_\.]/', '', $uniqueId), $file->getClientOriginalExtension());
            } else {
                $name = sprintf('%s', preg_replace('/[^a-zA-Z0-9-_\.]/', '', $uniqueId));
            }
        }
        return $name;
    }

    /**
     * Returns the directory for the userPortfolio for the Space
     */
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

    /**
     * Returns the directory for the userPortfolio for the Space
     */
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

    /**
     * Returns the directory for the userProfilePicture for the Space
     */
    public static function getUserProfilePicturePath($filename, $user){
        $path = sprintf("users/%s/profilepicture/%s", $user->slug, $filename);
        return $path;
    }

    /**
     * Returns a unique generated ID
     */
    public static function createUniqueid(){
        return uniqid();
    }

    /**
     * Returns directory for the Space of the userwork (innocreatives feed)
     */
    public static function getUserWorkDir($user, $userWork, $filename){
        $path = sprintf(
            'users/%s/userworks/%d/%s',
            $user->slug, $userWork->id, $filename
            );
        return $path;

    }

    /**
     * Returns the mimetype of given parameters
     *
     */
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