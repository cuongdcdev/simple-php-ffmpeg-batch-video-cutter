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

if(  getOS() == "windows" ){
	system("chcp 65001 &"); //system unicode display for windows, you must use unicode font in cmd to see this ! 
}



  // _____ _   _ ______ ____  
 // |_   _| \ | |  ____/ __ \ 
   // | | |  \| | |__ | |  | |
   // | | | . ` |  __|| |  | |
  // _| |_| |\  | |   | |__| |
 // |_____|_| \_|_|    \____/ 


// This program(currently) do a simple task: it trims your videos in input folder and output timmed videos to output folder , you can specify start time , end time !  
                           



   // _______     _______ _______ ______ __  __   _____  ______ ____  _    _ _____ _____  ______ __  __ ______ _   _ _______ 
  // / ____\ \   / / ____|__   __|  ____|  \/  | |  __ \|  ____/ __ \| |  | |_   _|  __ \|  ____|  \/  |  ____| \ | |__   __|
 // | (___  \ \_/ / (___    | |  | |__  | \  / | | |__) | |__ | |  | | |  | | | | | |__) | |__  | \  / | |__  |  \| |  | |   
  // \___ \  \   / \___ \   | |  |  __| | |\/| | |  _  /|  __|| |  | | |  | | | | |  _  /|  __| | |\/| |  __| | . ` |  | |   
  // ____) |  | |  ____) |  | |  | |____| |  | | | | \ \| |___| |__| | |__| |_| |_| | \ \| |____| |  | | |____| |\  |  | |   
 // |_____/   |_| |_____/   |_|  |______|_|  |_| |_|  \_\______\___\_\\____/|_____|_|  \_\______|_|  |_|______|_| \_|  |_|   
                                                                                                                          
                                                                                                                          

// OS: Windows 32/64bit | Linux currently support 64bit 
// php >= 5.6 
// if you using Windows, you need a working version of ffmpeg in system path, see how to install ffmpeg here: http://adaptivesamples.com/how-to-install-ffmpeg-on-windows/



  // _    _  ______          __  _______ ____    _    _  _____ ______ 
 // | |  | |/ __ \ \        / / |__   __/ __ \  | |  | |/ ____|  ____|
 // | |__| | |  | \ \  /\  / /     | | | |  | | | |  | | (___ | |__   
 // |  __  | |  | |\ \/  \/ /      | | | |  | | | |  | |\___ \|  __|  
 // | |  | | |__| | \  /\  /       | | | |__| | | |__| |____) | |____ 
 // |_|  |_|\____/   \/  \/        |_|  \____/   \____/|_____/|______|
                                                                   
                                                                   
// just run 

// ```
	// php c.php <input-video-folder> <output-video-folder> <time-cut-start>  <time-cut-end>
	
// ```

// if any parameter of them empty, it will use default setting in config section (line 73 - line 103 );

														   
																 																   



 // ######   #######  ##    ## ######## ####  ######   
// ##    ## ##     ## ###   ## ##        ##  ##    ##  
// ##       ##     ## ####  ## ##        ##  ##        
// ##       ##     ## ## ## ## ######    ##  ##   #### 
// ##       ##     ## ##  #### ##        ##  ##    ##  
// ##    ## ##     ## ##   ### ##        ##  ##    ##  
 // ######   #######  ##    ## ##       ####  ######    config ! 
 
 
$supportExt = array("mp4", "flv", "avi", "webm" , "mkv"); // hỗ trợ file nào !?

if( empty( $argv[3] ) )
	$startTime = 15; // thời gian theo giây, số giây bắt đầu ;
else{
	$startTime = getNumber( $argv[3] );
}

if( empty( $argv[4] ) ){
	$endTime = 15; // số giây kết thúc trước ( kiểu như video 6 phút thì bỏ 5 giây cuối -> ghi là 5  )
}else{
		$endTime = getNumber( $argv[4] );
}


// ######## ##    ## ########  
// ##       ###   ## ##     ## 
// ##       ####  ## ##     ## 
// ######   ## ## ## ##     ## 
// ##       ##  #### ##     ## 
// ##       ##   ### ##     ## 
// ######## ##    ## ########     





   // _____ _______       _____ _______    _____ ____  _____  ______  
  // / ____|__   __|/\   |  __ \__   __|  / ____/ __ \|  __ \|  ____| 
 // | (___    | |  /  \  | |__) | | |    | |   | |  | | |  | | |__    
  // \___ \   | | / /\ \ |  _  /  | |    | |   | |  | | |  | |  __|   
  // ____) |  | |/ ____ \| | \ \  | |    | |___| |__| | |__| | |____  
 // |_____/   |_/_/    \_\_|  \_\ |_|     \_____\____/|_____/|______| 
                                                                   

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
		die;
   }
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
