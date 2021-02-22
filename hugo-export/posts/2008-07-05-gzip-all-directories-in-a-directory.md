---
title: gzip all directories in a directory
categories:
  - Linux

---
I don&#8217;t know why I keep having to do this, but I do. I always to create  
separate archives of all the directories in a directory. So, here is  
script from David (aka Matir aka EmptyCinema) from linuxquestions.org <http://www.linuxquestions.org/questions/showthread.php?s=&postid=1839513#post1839513>

to do just that (along with a sample sessions using it).

#!/bin/bash  
for dir in */  
do dir=\`echo $dir | tr -d &#8216;/&#8217;\`  
echo $dir  
tar czf $dir.tar.gz $dir  
done

[jcz@actinella ~]$ ./zipdir.sh  
cdcatalogs  
ddclient-3.6.6  
Desktop

[jcz@actinella ~]$ ls -lht *.gz  
-rw-rw-r&#8211; 1 jcz jcz 17M Sep 6 23:31 Desktop.tar.gz  
-rw-rw-r&#8211; 1 jcz jcz 13K Sep 6 23:31 cdcatalogs.tar.gz  
-rw-rw-r&#8211; 1 jcz jcz 74K Sep 6 23:31 ddclient-3.6.6.tar.gz

Here is another more advanced version:

#!/bin/bash  
\# jcz 13-nov-05  
\# zips (or tar.gz) all directories  
\# in the directory in which it is run  
##################################  
echo &#8221; \***\***\***\***\***\***\***\***\***\**** &#8220;  
echo &#8221; this app zips all directories in this directory,&#8221;  
echo &#8221; tests the created zips for integrity, then &#8220;  
echo &#8221; copies them to some directory.&#8221;  
echo &#8221; \***\***\***\***\***\***\***\***\***\**** &#8220;

\# user enters the directory that they want the zips copied to  
echo -n &#8220;Destination directory for zips e.g. /cygdrive/f/BACKUPS ( . =  
here): &#8220;  
read dest

for dir in */  
do dir=\`echo $dir | tr -d &#8216;/&#8217;\`  
echo $dir

\# for zipping, -r recurse into directories  
\# echo &#8220;zip -r&#8221; $dir.zip $dir&#8217;/*&#8217;  
zip -ru $dir.zip $dir  
\# for gzipping  
\# tar czf $dir.tar.gz $dir  
done

\# to test zip file integrity  
for zipf in ls *.zip  
do zip -T $zipf  
done

\# move the zips to some directory  
for zipf in ls *.zip  
do mv -v $zipf $dest  
done