---
title: Search lister
author: John C. Zastrow
type: post
date: 2009-12-30T17:56:15+00:00
url: /2009/12/30/search-lister/
categories:
  - Linux

---
This little script needs a lot of help But it will recurse down through the current directory and create a listing of files, their folders, sizes, and modification dates and times. it was written to run on Windows under Cygwin.  


<pre>&lt;br /&gt;
#!/bin/sh&lt;br /&gt;
# v1 jcz 30-dec-2009&lt;br /&gt;
# This script will search for files of a certain type and create a text file of the results&lt;br /&gt;
# TODO:&lt;br /&gt;
#</pre>

############################  
\# enable for debugging #####  
############################  
\# set -vx

############################  
#  Global script variables block  
############################  
\# Date and other variables pretty self explanatory, S is seconds  
\# date format is currently YYYYMMDD_HHMMSS  
dater=$(date +%Y-%m-%d %H:%M:%S)  
dayer=$(date +%a)  
namer=$(whoami)  
hoster=$(hostname)  
directory=$(pwd)  
filenamer=$(date +%Y%m%d_%H%M%S).txt  
\# sets day of the week for incremental backups  
set $(date)

############################  
#  Clear the screen and introduce the user to the script  
############################

clear  
echo &#8220;&#8221;  
echo &#8220;WELCOME TO THE FIND TO LIST SCRIPT&#8221;  
echo &#8220;&#8221;

############################  
#  Wait for the user to enter a new file extension and capture the value as a variable  
############################  
echo -n &#8220;Enter file extension to search for, without the leading dot (e.g. txt): &#8221;  
read fileext

############################  
#  Wait for the user to enter a new file destination  
############################  
echo -n &#8220;Enter a new log file destination without ending slash (e.g., /cygdrive/c ): &#8221;  
read filedest

############################  
#  Create the log file for the script named after the file extension  
############################  
echo &#8220;&#8212;-&#8221; >> $filedest/$filenamer  
\# echo &#8220;&#8212;-&#8221; > $filedest/$fileext\_files\_from\_$directory\_on_$dater.txt  
echo &#8220;File created on: &#8220;$dater  >> $filedest/$filenamer  
echo &#8220;Setup script was run in: &#8220;$directory >> $filedest/$filenamer  
echo &#8220;By user&#8221; $namer  >> $filedest/$filenamer  
echo &#8220;Searching for files ending in: &#8221; $fileext >> $filedest/$filenamer  
echo &#8220;This file was written to: &#8221; $filedest/$filenamer >> $filedest/$filenamer  
echo &#8220;\***\***\***\***\***\***\***\***\***&#8221;  >>$filedest/$filenamer  
echo &#8220;&#8221; >> $filedest/$filenamer

find . -name &#8216;*.&#8217;$fileext -type f -print0 | xargs -0  stat -c &#8216;file: %N | bytes: %s | modtime: %y&#8217; >> $filedest/$filenamer

echo -n &#8220;Hit enter to continue &#8221;  
read none

echo &#8220;&#8221;  
echo &#8220;* Now I will show you the file and be done&#8221;  
echo &#8220;&#8221;  
echo -n &#8220;Hit enter to list or Ctrl-c to quit &#8221;  
read none  
less $filedest/$filenamer