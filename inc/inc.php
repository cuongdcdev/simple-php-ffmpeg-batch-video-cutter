<?php

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video;
use FFMpeg\FFProbe;

require_once( dirname(__DIR__) . "/vendor/autoload.php");
// ----------------- int class ---------------------
$Ffmpeg = FFMpeg::create();
$Ffprobe = FFProbe::create();

// ----------------- end class ----------------------
// 
// 
// -------------------------------- start functions ----------------------------------------------------------------------------------
// truyen array list file -> loc list file ho tro -> convert -> save();
// startTime = thoi gian bat dau convert 
// endTime = thoi gian cắt trước khi kết thúc ;
// $openDirPath : folder can xu li 
//  $saveDirPath : folder save da xu li 
function cutVideoAndSave($arrFileName, $arrSupportExt, $openDirPath, $saveDirPath, $startTime, $endTime) {
    $convertQueue = array();

    // check os 
    if (strtolower(PHP_OS) == "linux") {
        echo "-- support 64bit linux os -- \n ";
        $osType = "linux";
    } else {
        if (strtolower(PHP_OS) == "windows") {
            echo "-- support windows 32 + 64 bit -- \n ";
            $osType = "windows";
        } else {
            echo "Không hỗ trợ hệ điều hành này  " . PHP_OS;
            die;
        }
    }

    // check file hop le 
    foreach ($arrFileName as $file) {
        $arrName = explode(".", $file);
        if (in_array(strtolower($arrName[sizeof($arrName) - 1]), $arrSupportExt)) {
            echo $file . "\n";
            $convertQueue[] = $file;
        }
    }
    //check $convertQueeu co file 
    if (sizeof($convertQueue) == 0) {
        echo "\n Folder trống hoặc Không có file hợp lệ định dạng: " . implode(" ", $arrSupportExt) . " ! \n " ;
        die;
    }


    // tien hanh convert + save ;
    foreach ($convertQueue as $filePath) {
        // $endTime = tổng số giây lấy !
        $totalVideoTime = getVideoLength($filePath);
        echo "\n video length: " . $totalVideoTime . "\n"; 
        $arrFileInfo = explode(DIRECTORY_SEPARATOR, $filePath);
        $fileName = $arrFileInfo[sizeof($arrFileInfo) - 1  ];
        $videoEndTime = ( $totalVideoTime - $endTime ) > 0 ? ( $totalVideoTime - $endTime ) : ( $totalVideoTime - $startTime );
        $cmd = cutCommandBuilder( $fileName, $openDirPath , $saveDirPath, $startTime, $videoEndTime, $osType);
        
        echo "\n filename:" . $fileName . "\n";
        echo "\n CMD: ". $cmd . "\n";
        // @shell_exec($cmd);
    }

    echo "\n Convert xong ! , tổng cộng [ " . sizeof($convertQueue) . " ] file !  Lưu vào folder:  " . $saveDirPath . " \n ";
}

// function convert and save 

function getVideoLength($videoName) {
    global $Ffprobe;
    return $Ffprobe->streams($videoName)->videos()->first()->get("duration");
}

// build cutCommand 
function cutCommandBuilder($currentFileName, $openDir, $saveDir, $startTime, $endTime, $osType) {
    if ($osType == "linux") {
        $commandBuilt = "ffmpegLinux".DIRECTORY_SEPARATOR."ffmpeg -y -ss {$startTime} -t {$endTime} -i \"{$openDir}".DIRECTORY_SEPARATOR."{$currentFileName}\"  -vcodec copy -acodec copy \"{$saveDir}" . DIRECTORY_SEPARATOR. "{$currentFileName}\" &>/dev/null ";
    } else {
        $commandBuilt = "ffmpegWindows" . DIRECTORY_SEPARATOR . "ffmpeg -y -ss {$startTime} -t {$endTime} -i \"{$openDir}".DIRECTORY_SEPARATOR."{$currentFileName}\" -vcodec copy -acodec copy \"{$saveDir}" .DIRECTORY_SEPARATOR. "{$currentFileName}\" >nul 2>&1";
    }
    return $commandBuilt;
}

//  convert second -> hh:mm:ss
function convertSecondToTimeCode($timeSecond) {
    $oldTimeSecond = $timeSecond;
    $hour = 0;
    $min = 0;
    $second = 0;

    if ($timeSecond < 60) {
        $second = $timeSecond;
    }

    if ($timeSecond > 60) {
        while ($timeSecond / 60 > 1) {
            $min++;
            $timeSecond -= 60;
        }
    }

    if ($min > 60) {
        while ($min / 60 > 1) {
            $hour++;
            $min -= 60;
        }
    }
    echo "hour:{$hour} min: {$min} | second : {$timeSecond}" . " = " . $oldTimeSecond;

    return "{$hour}:${min}:{$timeSecond}";
}

; //convert second to TimeCode ;

	// -------------------------------------------- end functions ----------------------------------------------------------