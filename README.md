# Simple php-ffmpeg video cutter 

###Info

This program(currently) do a simple task: it trims your videos in input folder and output timmed videos to output folder , you can specify start time , end time !  
                           


### system requirement
                                                                                                                          

- OS: Linux,Windows 
- php >= 5.6 

you need a working version of ffmpeg on Linux or working version on system path Windows

( see how to install ffmpeg here: http://adaptivesamples.com/how-to-install-ffmpeg-on-windows/ )



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


<pre>
cut 5s from begining and cut 10s from end  for each video in /home/abc/video-in, after process complete, save videos to /home/abc/video-out :


         <code> <center> php c.php /home/abc/video-in /home/abc/video-out 5 10</center></code>
         
         
</pre>

if any parameter of them empty, it will use default setting in config section (line 73 - line 103 in `c.php` );
