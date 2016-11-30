# Simple php-ffmpeg batch video cutter 

###Info

This program(currently) do a simple task: it trims your videos in input folder and output timmed videos to output folder , you can specify start time , end time !  
                           


### system requirement
                                                                                                                          

- OS: Linux,Windows 
- php >= 5.6 

you need a working version of ffmpeg on Linux or working version on system path Windows

 for Windows,see how to install ffmpeg here: http://adaptivesamples.com/how-to-install-ffmpeg-on-windows/
 for Linux, see how to install ffmpeg here: https://ffmpeg.org/download.html
 



### How to use 
                                                                                                                         
just run 

```
	php c.php <input-video-folder> <output-video-folder> <time-cut-start>  <time-cut-end>
	
```

__Parameters:__ 

- `input-video-folder` : the absolute directory contains videos to be processed

- `output-video-folder` : the absolute directory folder contains videos to be saved after process complete 

- `time-cut-start` : the time start to be cut from video

- `time-cut-end` : the time end to be cut from video 


__Example__


cut __5s__ from begining and cut __10s__ from end  for each video in __/home/abc/video-in__, after process complete, save videos to __/home/abc/video-out__ :
         
 ``` 
   	php c.php /home/abc/video-in /home/abc/video-out 5 10
```
         


if any parameter of them empty, it will use default setting in config section (line 73 - line 103 in `c.php` );
