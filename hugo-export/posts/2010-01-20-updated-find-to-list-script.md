---
categories:
  - Uncategorized

---

<pre>&lt;span style="color: #333399;"&gt;#!/bin/sh
# v1 jcz 30-dec-2009
# This is a silly little script that will search 
# TODO: 
#  - Everything
# - Fix this script to run under cygwin 1.7.X after working fine under 1.5.X

############################
# enable for debugging #####
############################
# set -vx

############################
#  Global script variables block
############################
# Date and other variables pretty self explanatory, S is seconds
 namer=$(whoami)
 hoster=$(hostname)
 directory=$(pwd)
# sets day of the week for incremental backups

############################
#  Clear the screen and introduce the user to the script
############################

clear
echo ""
echo "WELCOME TO THE FIND TO LIST SCRIPT"
echo ""

############################
#  Wait for the user to enter a new file extension and capture the value as a variable
############################
echo ""
echo -n "Enter file extension to search for, without the leading dot (e.g. txt): "
read fileext
echo ""
echo ""

############################
#  Wait for the user to enter a new file destination
############################
echo -n "Enter a new log file destination without ending slash (e.g., /cygdrive/c ): "
read filedest
echo ""
echo ""

############################
#  Create the file for the script named after the file extension
############################
echo "----" &gt;&gt; $filedest/$filenamer
echo "Script was run in: "$directory &gt;&gt; $filedest/$filenamer
echo "By user: " $namer  &gt;&gt; $filedest/$filenamer
echo "Searching for files ending in: " $fileext &gt;&gt; $filedest/$filenamer
echo "This file was written to: " $filedest/$filenamer &gt;&gt; $filedest/$filenamer
echo "***************************"  &gt;&gt;$filedest/$filenamer
echo "" &gt;&gt; $filedest/$filenamer


echo -n "Hit enter to continue "
read none

echo ""
echo "* Now I will show you the file and be done"
echo ""
echo -n "Hit enter to list or Ctrl-c to quit "
read none
less $filedest/$filenamer&lt;/span&gt;</pre>