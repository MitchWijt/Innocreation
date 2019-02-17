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

        const LARGE_TIMES = 2;
        const SMALL_DEVIDER = 2;
        const EXTRASMALL_DEVIDER = 4;

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

        public function resize($file, $fileRealPath, $targets, $uniqueId){
            $images = [];
            foreach($targets as $key){

                $width = self::getWidthAndHeight($key, $file)['width'];
                $height = self::getWidthAndHeight($key, $file)['height'];

                $filedata = self::getImageData($fileRealPath);
                $tempfile = self::tempFile();

                $image = new \Imagick();
                $image->readImageBlob($filedata);
                $image->resizeImage($width, $height, \Imagick::STYLE_NORMAL,1);
                $image->setImageFormat($file->getClientOriginalExtension());
                file_put_contents($tempfile, $image);

                $filename = PublicPaths::getFilenameResized($uniqueId, $file, $key);
                array_push($images, ['file' => $tempfile, 'filename' => $filename]);
            }
            return $images;
        }

        public static function getWidthAndHeight($target, $file){
            $data = getimagesize($file);
            $realWidth = $data[0];
            $realHeight = $data[1];
            if($target == "large"){
                $width = $realWidth * self::LARGE_TIMES;
                $height = $realHeight * self::LARGE_TIMES;
            } else if($target == "small"){
                $width = $realWidth / self::SMALL_DEVIDER;
                $height = $realHeight / self::SMALL_DEVIDER;
            } else if($target == "extra-small"){
                $width = $realWidth / self::EXTRASMALL_DEVIDER;
                $height = $realHeight / self::EXTRASMALL_DEVIDER;
            } else {
                $width = $realWidth;
                $height = $realHeight;
            }

            return ['width' => $width, 'height' => $height];
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