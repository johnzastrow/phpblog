---
title: Convert Android .3GP movies to .MP4 on windows
author: John C. Zastrow
type: post
date: 2012-05-25T21:22:13+00:00
url: /2012/05/25/convert-android-3gp-movies-to-mp4-on-windows/
categories:
  - Data processing
  - Home and Family
  - Web

---
Hardly any software works well with .3GP movie files. So, with this collection of movies accumulating in my phone sync folder I needed something to convert them into formats that are more useful (like video editing software or upload sites). So, here&#8217;s a little quick and dirty solution for batch converting these files on a Windows machine &#8211; with pretty high quality I might add. Of course there are a lot of other things you can do with ffmpeg, so be sure to explore&#8230;

Step 1. Install [cygwin][1] command line so that you can use the bash shell to loop through stuff on Windows.

Step 2. Download the \*static\* binaries for windows from this site <http://ffmpeg.zeranoe.com/builds/>{.broken_link}

Step 3. You are lazy like me, so copy those binaries right into the /bin directory in cygwin so they are available at the command line without any salutes.

[<img loading="lazy" class="alignnone size-medium wp-image-475" title="bin" src="http://northredoubt.com/n/wp-content/uploads/2012/05/bin-300x253.gif" alt="" width="300" height="253" srcset="http://northredoubt.com/n/wp-content/uploads/2012/05/bin-300x253.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/05/bin.gif 320w" sizes="(max-width: 300px) 100vw, 300px" />][2]

Step 4. Put the script below into the same /bin directory because you are lazy

<pre class="lang:bash decode:1 " ></pre>

#!/bin/bash  
\# jcz 25-may-12  
\# filename: 3gp2mp4.sh  
\# converts all 3GP video files in the directory  
\# where it is run. Logs all file contents  
\# and errors to a text file in the directory  
\# in which it is run  
#  
##################################

############################  
\# Global script variables block  
############################  
\# Date and other variables pretty self explanatory, S is seconds  
\# date format is currently YYYYMMDD_HHMMSS  
dater=$(date)  
dayer=$(date +%a%F%H%m)  
namer=$(whoami)  
hoster=$(hostname)  
directory=$(pwd)  
filenamer=$(date +%a\_%F\_%H\_%M\_%S)\_3gp\_convertlog  
\# sets day of the week  
set $(date)  
logger=$filenamer.txt  
############################  
\# END Global script variables block  
############################  
echo &#8220;Welcome, $namer. I&#8217;m running in $directory and I will convert all 3GP phone videos to here mp4 files. &#8221;  
echo &#8221; &#8221;  
echo &#8220;I see the following files to convert. I will write them down for you now &#8221;  
ls *.3gp 2> deleteme.txt  
echo &#8221; &#8221;  
echo &#8220;Please review the file $filenamer in this folder when I&#8217;m done. &#8221;  
echo &#8221; &#8221;  
echo &#8221; &#8221;  
echo &#8220;\***\***\****\*\\*\* RUNNING \*\*\***\***\***\***** &#8221;

echo &#8220;[START] &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
echo &#8220;\***\****\*\\*\* START RUN LOG HEADER \*\*\***\***\***\**** &#8221; >> $logger  
echo &#8220;Dater: &#8221; $dater >> $logger  
echo &#8220;Username: &#8221; $namer >> $logger  
echo &#8220;Computer: &#8221; $hoster >> $logger  
echo &#8220;Directory: &#8221; $directory >> $logger  
echo &#8221; &#8221; >>$logger  
echo &#8220;\***\****\*\\*\* END RUN LOG HEADER \*\*\***\***\***\**** &#8221; >> $logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger

\# The & characters after the commands log all output (stdout and stderr) to the log file  
echo &#8220;I see the following files to work on. I will write them down for you now &#8221; >> $logger  
ls -lh *.3gp >> $logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger

\# Rename any existing .Mp4 files so they don&#8217;t get over written and stop ffmpeg from asking me if I want to over write them  
echo &#8220;Moving files: &#8221; ls *.mp4  
for nowmp4s in *.mp4  
do  
mv -v $nowmp4s $dayer-$nowmp4s.mp4 >> $logger  
done

\# Now loop through the files and convert them using -sameq inside of ffmpeg.  
for phonevid in *.3gp  
do  
echo &#8220;&#8212;- START $phonevid ARCHIVE INFO &#8212;- &#8221; >> $logger  
stat $phonevid >> $logger  
echo &#8220;&#8212;- END $phonevid ARCHIVE INFO &#8212;- &#8221; >> $logger  
echo &#8221; &#8221; >>$logger  
echo &#8220;~~~~~~~~~~~~~ START FILES IN ARCHIVE $phonevid ~~~~~~~~~~~ &#8221; >> $logger  
echo &#8220;Converting: $phonevid &#8221;  
ffmpeg -i $phonevid -sameq $phonevid.mp4 >> $logger  
echo &#8220;~~~~~~~~~~~~~ END FILES IN ARCHIVE $phonevid ~~~~~~~~~~~ &#8221; >> $logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
echo &#8221; &#8221; >>$logger  
done

echo &#8220;[END] &#8221; >>$logger  
echo &#8221; &#8221; >>$logger

\# make my log a little more readble in windows  
unix2dos $filenamer.txt  
echo &#8221; &#8221;  
echo &#8221; &#8221;  
echo &#8220;\***\***\****\*\\*\* DONE \*\*\***\***\***\***** &#8221;

Step 5. Using cygwin, change into a directory containing some .3gp files you want to convert and run it. You will send up with one .mp4 file for each .3gp file you started with in that directory.

<p style="padding-left: 30px;">
  <em>john.zastrow@DIVL-GY4K3R1 /cygdrive/c/Users/john.zastrow/Videos/PhoneVids</em><br /> <em>$ 3gp2mp4.sh</em><br /> <em>Welcome, john.zastrow. I&#8217;m running in /cygdrive/c/Users/john.zastrow/Videos/Phon eVids and I will convert all 3GP phone videos to here mp4 files.</em>
</p>

_I see the following files to convert. I will write them down for you now_  
_VIDEO0001.3gp VIDEO0013.3gp VIDEO0025.3gp VIDEO0037.3gp VIDEO0049.3gp_  
_VIDEO0002.3gp VIDEO0014.3gp VIDEO0026.3gp VIDEO0038.3gp VIDEO0050.3gp_

_\# <snip>_

_Please review the file Fri\_2012-05-25\_17\_06\_28\_3gp\_convertlog in this folder whe n I&#8217;m done._  
_\***\***\****\*\\*\* RUNNING \*\*\***\***\***\*****_  
_Moving files: ls VIDEO0001.3gp.mp4 VIDEO0002.3gp.mp4 VIDEO0003.3gp.mp4 VIDEO000 4.3gp.mp4 VIDEO0005.3gp.mp4 VIDEO0006.3gp.mp4 VIDEO0007.3gp.mp4 VIDEO0008.3gp.mp 4 VIDEO0009.3gp.mp4 VIDEO0010.3gp.mp4 _

<p style="padding-left: 30px;">
  <em># <snip></em>
</p>

You&#8217;ll also get a very verbose log file of what the starting files looked like (stat) and what ffmpeg saw and did. I do love my log files 🙂

<pre class="lang:bash decode:1 " >[START]
********** START RUN LOG HEADER ***************
Dater: Fri, May 25, 2012 5:06:28 PM
Username: john.zastrow
Computer: DIVL-GY4K3R1
Directory: /cygdrive/c/Users/john.zastrow/Videos/PhoneVids

********** END RUN LOG HEADER ***************

&nbsp;

I see the following .tar.gz files to expand. I will write them down for you now
-rwx------+ 1 john.zastrow Domain Users 12M Dec 2 2010 VIDEO0001.3gp
-rwx------+ 1 john.zastrow Domain Users 11M Dec 4 2010 VIDEO0002.3gp

#&lt;snip>



<pre>VIDEO0001.3gp.mp4' -&gt; </pre>Fri2012-05-251705.mp4'
&lt;span style= "font-size: x-small; ">&lt;span style= "line-height: 19px; "># &lt;snip>
&lt;/span>&lt;/span>
---- START VIDEO0001.3gp ARCHIVE INFO ----
 File: `VIDEO0001.3gp'
 Size: 12056791 Blocks: 11776 IO Block: 65536 regular file
Device: 92b3f5b8h/2461267384d Inode: 2533274790709757 Links: 1
Access: (0700/-rwx------) Uid: (57187/john.zastrow) Gid: (10513/Domain Users)
Access: 2011-11-22 09:24:06.582765500 -0500
Modify: 2010-12-02 19:12:12.000000000 -0500
Change: 2012-05-24 14:44:14.228090700 -0400
 Birth: 2011-11-22 09:24:06.582765500 -0500
---- END VIDEO0001.3gp ARCHIVE INFO ----

~~~~~~~~~~~~~ START FILES IN ARCHIVE VIDEO0001.3gp ~~~~~~~~~~~
ffmpeg version N-40824-g31dfe20 Copyright (c) 2000-2012 the FFmpeg developers
 built on May 19 2012 00:45:59 with gcc 4.6.3
 configuration: --enable-gpl --enable-version3 --disable-w32threads --enable-runtime-cpudetect --enable-avisynth --enable-bzlib --enable-frei0r --enable-libass --enable-libcelt --enable-libopencore-amrnb --enable-libopencore-amrwb --enable-libfreetype --enable-libgsm --enable-libmp3lame --enable-libnut --enable-libopenjpeg --enable-librtmp --enable-libschroedinger --enable-libspeex --enable-libtheora --enable-libutvideo --enable-libvo-aacenc --enable-libvo-amrwbenc --enable-libvorbis --enable-libvpx --enable-libx264 --enable-libxavs --enable-libxvid --enable-zlib
 libavutil 51. 53.100 / 51. 53.100
 libavcodec 54. 21.101 / 54. 21.101
 libavformat 54. 5.100 / 54. 5.100
 libavdevice 53. 4.100 / 53. 4.100
 libavfilter 2. 74.101 / 2. 74.101
 libswscale 2. 1.100 / 2. 1.100
 libswresample 0. 12.100 / 0. 12.100
 libpostproc 52. 0.100 / 52. 0.100
Guessed Channel Layout for Input Stream #0.1 : mono
Input #0, mov,mp4,m4a,3gp,3g2,mj2, from 'VIDEO0001.3gp':
 Metadata:
 major_brand : 3gp4
 minor_version : 768
 compatible_brands: 3gp4mp413gp6
 creation_time : 2010-12-03 00:11:40
 copyright :
 copyright-eng :
 Duration: 00:00:32.44, start: 0.000000, bitrate: 2972 kb/s
 Stream #0:0(eng): Video: mpeg4 (Simple Profile) (mp4v / 0x7634706D), yuv420p, 800x480 [SAR 1:1 DAR 5:3], 2958 kb/s, 10.23 fps, 60 tbr, 1k tbn, 60 tbc
 Metadata:
 creation_time : 2010-12-03 00:11:40
 handler_name : VideoHandler
 Stream #0:1(eng): Audio: amr_nb (samr / 0x726D6173), 8000 Hz, mono, flt, 12 kb/s
 Metadata:
 creation_time : 2010-12-03 00:11:40
 handler_name : SoundHandler
[buffer @ 03aa86c0] w:800 h:480 pixfmt:yuv420p tb:1/1000000 sar:1/1 sws_param:flags=2
[buffersink @ 03aa8720] No opaque field provided
[abuffer @ 03aa87c0] format:flt layout:mono rate:8000
[aformat @ 03aa8880] auto-inserting filter 'auto-inserted resampler 0' between the filter 'src' and the filter 'aformat'
[aresample @ 03aa88c0] r:8000Hz -> r:8000Hz
[libx264 @ 03aa6400] using SAR=1/1
[libx264 @ 03aa6400] using cpu capabilities: MMX2 SSE2Fast SSSE3 FastShuffle SSE4.2 AVX
[libx264 @ 03aa6400] profile High, level 3.1
[libx264 @ 03aa6400] 264 - core 120 r2164 da19765 - H.264/MPEG-4 AVC codec - Copyleft 2003-2012 - http://www.videolan.org/x264.html - options: cabac=1 ref=3 deblock=1:0:0 analyse=0x3:0x113 me=hex subme=7 psy=1 psy_rd=1.00:0.00 mixed_ref=1 me_range=16 chroma_me=1 trellis=1 8x8dct=1 cqm=0 deadzone=21,11 fast_pskip=1 chroma_qp_offset=-2 threads=6 sliced_threads=0 nr=0 decimate=1 interlaced=0 bluray_compat=0 constrained_intra=0 bframes=3 b_pyramid=2 b_adapt=1 b_bias=0 direct=1 weightb=1 open_gop=0 weightp=2 keyint=250 keyint_min=25 scenecut=40 intra_refresh=0 rc_lookahead=40 rc=crf mbtree=1 crf=23.0 qcomp=0.60 qpmin=0 qpmax=69 qpstep=4 ip_ratio=1.40 aq=1:1.00
strptime() unavailable on this system, cannot convert the date string.
Output #0, mp4, to 'VIDEO0001.3gp.mp4':
 Metadata:
 major_brand : 3gp4
 minor_version : 768
 compatible_brands: 3gp4mp413gp6
 creation_time : 2010-12-03 00:11:40
 copyright :
 copyright-eng :
 encoder : Lavf54.5.100
 Stream #0:0(eng): Video: h264 (![0][0][0] / 0x0021), yuv420p, 800x480 [SAR 1:1 DAR 5:3], q=-1--1, 60 tbn, 60 tbc
 Metadata:
 creation_time : 2010-12-03 00:11:40
 handler_name : VideoHandler
 Stream #0:1(eng): Audio: aac (@[0][0][0] / 0x0040), 8000 Hz, mono, s16, 128 kb/s
 Metadata:
 creation_time : 2010-12-03 00:11:40
 handler_name : SoundHandler
Stream mapping:
 Stream #0:0 -> #0:0 (mpeg4 -> libx264)
 Stream #0:1 -> #0:1 (amrnb -> libvo_aacenc)
Press [q] to stop, [?] for help
frame= 63 fps=0.0 q=31.0 size= 33kB time=00:00:00.18 bitrate=1488.0kbits/s dup=52 drop=0 frame= 85 fps= 79 q=31.0 size= 90kB time=00:00:00.55 bitrate=1335.5kbits/s dup=70 drop=0 frame= 107 fps= 65 q=31.0 size= 130kB time=00:00:00.91 bitrate=1162.9kbits/s dup=88 drop=0 frame= 129 fps= 60 q=31.0 size= 195kB time=00:00:01.28 bitrate=1242.5kbits/s dup=106 drop=0 frame= 156 fps= 56 q=31.0 size= 262kB tim
# &lt;snip>

</pre>

<span style="color: #333333; font-style: normal; line-height: 24px;">And you&#8217;ll end up with files like this</span>

<a style="font-style: normal; line-height: 24px;" href="http://northredoubt.com/n/wp-content/uploads/2012/05/output.gif"><img loading="lazy" class="size-full wp-image-477 alignnone" title="output" src="http://northredoubt.com/n/wp-content/uploads/2012/05/output.gif" alt="" width="288" height="222" /></a>

 [1]: http://www.cygwin.com
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/05/bin.gif