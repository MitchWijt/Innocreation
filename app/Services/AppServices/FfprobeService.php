<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 23/12/2018
 * Time: 17:29
 */

namespace App\Services\AppServices;


use FFMpeg\FFProbe;

class FfprobeService
{
    private $ffprobe;
    public function __construct() {
        $this->ffprobe = FFProbe::create([
            'ffmpeg.binaries'  => getenv("FFMPEG_DIR"),
            'ffprobe.binaries' => getenv("FFPROBE_DIR")
        ]);
    }

    public function getDuration($file){
        $duration = $this->ffprobe
            ->streams($file)
            ->videos()
            ->first()
            ->get('duration');
        return $duration;
    }
}