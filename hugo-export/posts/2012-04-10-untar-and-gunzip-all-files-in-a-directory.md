---
title: Untar and gunzip all files in a directory
categories:
  - Data processing
  - Linux

---
I needed a little script to expand a bunch of tarred and gzipped files in a directory and I needed a log of what happened.. and didn&#8217;t happen (errors). So, here it is.

<pre>#!/bin/bash
 # jcz 16-mar-12
 # filename: untgzall.sh
 # untars (with gzip) all tar gzips in the directory
 # where it is run. Logs all file contents
 # and errors to a text file in the directory
 # in which it is run
 #
 ##################################

############################
 # Global script variables block
 ############################
 # Date and other variables pretty self explanatory, S is seconds
 namer=$(whoami)
 hoster=$(hostname)
 directory=$(pwd)
 # sets day of the week
 logger=$filenamer.txt
 ############################
 # END Global script variables block
 ############################
 echo "Welcome, $namer. I'm running in $directory and I will expand all tarred and gzipped files to here."
 echo ""
 echo "I see the following files to expand. I will write them down for you now"
 ls *.tar.gz 2&gt; deleteme.txt
 ls *.tgz 2&gt; deleteme.txt
 echo ""
 echo "Please review the file $filenamer in this folder when I'm done."
 echo ""
 echo ""
 echo "************* RUNNING ****************"

echo "[START]" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "********** START RUN LOG HEADER ***************" &gt;&gt; $logger
 echo "Username:" $namer &gt;&gt; $logger
 echo "Computer:" $hoster &gt;&gt; $logger
 echo "Directory:" $directory &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "********** END RUN LOG HEADER ***************" &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger

# The & characters after the commands log all output (stdout and stderr) to the log file
 echo "I see the following .tar.gz files to expand. I will write them down for you now" &gt;&gt; $logger
 ls -lh *.tar.gz &&gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger

for zp in *.tar.gz
 do
 echo "---- START $zp ARCHIVE INFO ----" &gt;&gt; $logger
 stat $zp &&gt;&gt; $logger
 echo "---- END $zp ARCHIVE INFO ----" &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "~~~~~~~~~~~~~ START FILES IN ARCHIVE $zp ~~~~~~~~~~~" &gt;&gt; $logger
 echo "Expanding: $zp"
 tar xzvf $zp &&gt;&gt; $logger
 echo "~~~~~~~~~~~~~ END FILES IN ARCHIVE $zp ~~~~~~~~~~~" &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 done
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "I see the following .tgz files to expand. I will write them down for you now" &gt;&gt; $logger
 ls -lh *.tgz &&gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger

for tz in *.tgz
 do
 echo "---- START $tz ARCHIVE INFO ----" &gt;&gt; $logger
 stat $tz &&gt;&gt; $logger
 echo "---- END $tz ARCHIVE INFO ----" &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "~~~~~~~~~~~~~ START FILES IN ARCHIVE $tz ~~~~~~~~~~~" &gt;&gt; $logger
 echo "Expanding: $tz"
 tar xzvf $tz &&gt;&gt; $logger
 echo "~~~~~~~~~~~~~ END FILES IN ARCHIVE $tz ~~~~~~~~~~~" &gt;&gt; $logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 done

echo "[END]" &gt;&gt;$logger
 echo "" &gt;&gt;$logger
 unix2dos $filenamer.txt
 echo ""
 echo ""
 echo "************* DONE ****************"</pre>

Which gives us the following output at the command line

<pre>&lt;/pre&gt;
$ untgzall.sh
 Welcome, john.zastrow. I'm running in /home/john.zastrow and I will expand all tarred and gzipped files to here.

I see the following files to expand. I will write them down for you now
 test.tar.gz
 deleteme.tgz test.tgz

Please review the file Tue_2012-04-10_21_47_05_untgzlog in this folder when I'm done.
 ************* RUNNING ****************
 Expanding: test.tar.gz
 Expanding: deleteme.tgz
 Expanding: test.tgz
 unix2dos: converting file Tue_2012-04-10_21_47_05_untgzlog.txt to DOS format ...
 ************* DONE ****************</pre>

and the following output in the file called Tue\_2012-04-10\_21\_47\_05_untgzlog.txt. Notice there file that errored out.

<pre>&lt;/pre&gt;
[START]
 ********** START RUN LOG HEADER ***************
 Dater: Tue, Apr 10, 2012 9:47:04 PM
 Username: john.zastrow
 Computer: DIVL-GY4K3R1
 Directory: /home/john.zastrow

********** END RUN LOG HEADER ***************

I see the following .tar.gz files to expand. I will write them down for you now
 -rw-r--r-- 1 john.zastrow Domain Users 11M Mar 13 04:00 test.tar.gz

---- START test.tar.gz ARCHIVE INFO ----
 File: `test.tar.gz'
 Size: 10862048 Blocks: 10608 IO Block: 65536 regular file
 Device: 92b3f5b8h/2461267384d Inode: 804736958415954494 Links: 1
 Access: (0644/-rw-r--r--) Uid: (57187/john.zastrow) Gid: (10513/Domain Users)
 Access: 2012-03-13 13:10:00.000000000 -0400
 Modify: 2012-03-13 04:00:45.000000000 -0400
 Change: 2012-04-10 21:46:01.572102800 -0400
 Birth: 2012-03-13 13:09:44.433265300 -0400
 ---- END test.tar.gz ARCHIVE INFO ----

~~~~~~~~~~~~~ START FILES IN ARCHIVE test.tar.gz ~~~~~~~~~~~
 tar: This does not look like a tar archive
 tar: Skipping to next header
 tar: Exiting with failure status due to previous errors
 ~~~~~~~~~~~~~ END FILES IN ARCHIVE test.tar.gz ~~~~~~~~~~~
 I see the following .tgz files to expand. I will write them down for you now
 -rw-r--r-- 1 john.zastrow Domain Users 51 Apr 10 21:46 deleteme.tgz
 -rw-r--r-- 1 john.zastrow Domain Users 189 Apr 10 21:45 test.tgz

---- START deleteme.tgz ARCHIVE INFO ----
 File: `deleteme.tgz'
 Size: 51 Blocks: 1 IO Block: 65536 regular file
 Device: 92b3f5b8h/2461267384d Inode: 3659174697428854 Links: 1
 Access: (0644/-rw-r--r--) Uid: (57187/john.zastrow) Gid: (10513/Domain Users)
 Access: 2012-04-10 21:46:56.546599300 -0400
 Modify: 2012-04-10 21:46:56.562199400 -0400
 Change: 2012-04-10 21:46:56.562199400 -0400
 Birth: 2012-04-10 21:46:56.546599300 -0400
 ---- END deleteme.tgz ARCHIVE INFO ----

~~~~~~~~~~~~~ START FILES IN ARCHIVE deleteme.tgz ~~~~~~~~~~~

gzip: stdin: not in gzip format
 tar: Child returned status 1
 tar: Error is not recoverable: exiting now
 ~~~~~~~~~~~~~ END FILES IN ARCHIVE deleteme.tgz ~~~~~~~~~~~

---- START test.tgz ARCHIVE INFO ----
 File: `test.tgz'
 Size: 189 Blocks: 1 IO Block: 65536 regular file
 Device: 92b3f5b8h/2461267384d Inode: 4785074604212675 Links: 1
 Access: (0644/-rw-r--r--) Uid: (57187/john.zastrow) Gid: (10513/Domain Users)
 Access: 2012-04-10 21:45:03.602401000 -0400
 Modify: 2012-04-10 21:45:03.680401100 -0400
 Change: 2012-04-10 21:45:03.680401100 -0400
 Birth: 2012-04-10 21:45:03.602401000 -0400
 ---- END test.tgz ARCHIVE INFO ----

~~~~~~~~~~~~~ START FILES IN ARCHIVE test.tgz ~~~~~~~~~~~
 deleteme.txt
 ~~~~~~~~~~~~~ END FILES IN ARCHIVE test.tgz ~~~~~~~~~~~

[END]</pre>