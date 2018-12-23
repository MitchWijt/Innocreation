<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 22/12/2018
 * Time: 15:42
 */

namespace App\Services\AppServices;


use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Storage;

class FfmpegService
{
    private $ffmpeg;
    public function __construct() {
        $this->ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => getenv("FFMPEG_DIR"),
            'ffprobe.binaries' => getenv("FFPROBE_DIR")
        ]);
    }

    public function extractThumbnailSaveToCdn($videoFile, $cdnDir, $filename){
        $video = $this->ffmpeg->open($videoFile);
        $frame = $video->frame(TimeCode::fromSeconds(40));
        $tmpfname = tempnam(sys_get_temp_dir(), "thumbnail");
        $frame->save('/var/www/secret/public/images/thumbnail.jpg');

        $img = file_get_contents("/var/www/secret/public/images/thumbnail.jpg");
        $handle = fopen($tmpfname, "w");
        fwrite($handle, $img);
        fclose($handle);

        Storage::disk('spaces')->put($cdnDir . "/". $filename, file_get_contents($tmpfname), "public");

        unlink($tmpfname);
    }
}