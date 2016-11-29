<?php
//MIT License
//
//Copyright (c) 2016 duongcuong96@gmail.com
//
//Permission is hereby granted, free of charge, to any person obtaining a copy
//of this software and associated documentation files (the "Software"), to deal
//in the Software without restriction, including without limitation the rights
//to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
//copies of the Software, and to permit persons to whom the Software is
//furnished to do so, subject to the following conditions:
//
//The above copyright notice and this permission notice shall be included in all
//copies or substantial portions of the Software.
//
//THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
//IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
//FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
//AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
//LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
//OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//SOFTWARE.

// use it whatever you want for any purpose but please keep license! Thanks :D 

//HOW TO USE ? see README.md !

require_once("inc/inc.php");

// THAM SO CONFIG :
$supportExt = array("mp4", "flv", "avi", "webm"); // hỗ trợ file nào !?
// dir in 
if (!empty($argv[1])) {
    if (!is_dir($argv[1])) {
        echo "Sai đường dẫn mở files !!!! \n ";
        die;
    }
    $convertDir = rtrim($argv[1] , DIRECTORY_SEPARATOR );
} else {
    $convertDir = __DIR__; // đường dẫn folder chứa file cần xử lí néu ko truyền tham số, mặc định là folder hiện tại  
}

// dir output 
if (!empty($argv[2])) {
    if (!is_dir($argv[2])) {
        echo " Sai đường dẫn lưu file  !!! \n ";
        die;
    }
    $convertedDir = rtrim($argv[2] , DIRECTORY_SEPARATOR);
} else {
    $convertedDir = __DIR__ .DIRECTORY_SEPARATOR. "video-out"; // đường dẫn mặc định folder chứa file lưu sau khi xử lí  
}

$startTime = 15; // thời gian theo giây, số giây bắt đầu ;
$endTime = 15; // số giây kết thúc trước ( kiểu như video 6 phút thì bỏ 5 giây cuối -> ghi là 5  )
// END THAM SO CONFIG 

// DEBUG INFO 
    echo "OS: " . PHP_OS . "\n";
    echo "CONVERTE : " . $convertDir . " - " . $convertedDir . "\n";
    echo "[Folder Input]: " ;
    echo empty($convertDir) ? "folder hien tai \n" : $convertDir . "\n";
    echo "[Folder Output]: ";
    echo  empty($convertedDir) ? "folder hien tai \n" : $convertedDir . "\n" ;
// END DEBUG INFO 

//--------------------------------------------------------------------- PROGRAM START -------------------------------------------------------------------------------------------------------------------------------------

//get file list 
if (empty($convertDir)) {
    $fileList = glob("*.*");
} else {
    $fileList = glob("{$convertDir}" . DIRECTORY_SEPARATOR . "*.*");
}


// tao dir neu ko ton tai 
if (!file_exists($convertedDir)) {
    if (!mkdir($convertedDir, 0777, true)) {
        echo "Không thể tạo thư mục: " . $convertedDir . " vui lòng tạo folder thủ công và cấp quyền ghi cho folder !\n";
    }
    die;
}

//check dir writeable 
if (!is_writeable($convertedDir)) {
    echo "{$convertedDir} tồn tại nhưng không có quyền ghi, cấp quyền ghi 777 vào folder này ! ";
    die;
}

// convert and save to dir 
// paramS: $arrFileName ,  $arrSupportExt , $saveDirPath , $startTime , $endTime(in seconds) 
cutVideoAndSave($fileList, $supportExt, $convertDir, $convertedDir, $startTime, $endTime);


// ---------------------------------------------- END --------------------------------------------------------------------------------------------
