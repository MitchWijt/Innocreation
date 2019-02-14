<?php
    /**
     * Created by PhpStorm.
     * User: mitchelwijt
     * Date: 30/01/2019
     * Time: 19:18
     */
    namespace App\Services\Images;
    use App\Services\Paths\PublicPaths;
    use Illuminate\Support\Facades\Storage;
    class ImageProcessor {
        const PLACEHOLDER_QUALITY = 10;

        public function createPlaceholder($file, $filePath, $path){
            $filedata = self::getImageData($filePath);
            $tempfile = self::tempFile();

            $image = new \Imagick();
            $image->readImageBlob($filedata);
            $image->setCompressionQuality(self::PLACEHOLDER_QUALITY);
            $image->blurImage(60, 30);
            $image->setImageFormat($file->getClientOriginalExtension());
            file_put_contents ($tempfile, $image);

            $this->upload($tempfile, $path, true);
        }

        public function upload($image, $path, $placeholder = false, $imageRealPath = null){
            if($placeholder){
                Storage::disk('spaces')->put($path, file_get_contents($image), "public");
                unlink($image);
            } else {
                Storage::disk('spaces')->put($path, file_get_contents($imageRealPath), "public");
            }

        }

        public static function getImageData($image){
            return file_get_contents($image);
        }

        public static function tempFile(){
            $tempfile = tempnam(sys_get_temp_dir(), "");
            return $tempfile;
        }

        public static function formatBytes($bytes, $precision = 2){
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