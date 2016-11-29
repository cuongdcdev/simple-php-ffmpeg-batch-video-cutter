<?php

////     
//$shortOpts = "";
//$shortOpts .= "d:"; // : la bat buoc 
//$shortOpts .= "c::"; // cai nay ko bat buoc 
//$shortOpts .= "abc"; // cai nay ko chap nhan value 
//
//$longOpts = array(
//    "required:", //yeu cau 
//    "optional::", //tuy chon value 
//    "option", // ko value 
//    "opt" // ko value
//);
//
//@$option = getopt($shortOpts, $longopts);
//if (!$option) {
//    echo "bạn phải điền đầy đủ tham số ! ";
//} else
//    var_dump($option);

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video;
use FFMpeg\Filters\Video\ClipFilter;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;

require_once("vendor/autoload.php");
$ffmpeg = FFMpeg::create();
$video = $ffmpeg->open("fool.mp4");
$ffprobe = FFProbe::create()->streams("fool.mp4");
$video_codec = $ffprobe->videos()->first()->get("duration");
$audio_codec = $ffprobe->audios()->first()->get("codec_name");


echo "dur: " . $video_codec . " | audio codec :  " . $audio_codec;


if (strtolower(PHP_OS) == "linux") {
    $cutString = "./ffmpeg -y -ss 00:00:25 -t " . ( $video_codec - 5 ) . " -i fool.mp4 -vcodec copy -acodec copy abc/out.mp4";
} else
if (strtolower(PHP_OS) == "windows") {
    
} else {
    echo "this tool not support this os ! ";
    die;
}
shell_exec($cutString);
