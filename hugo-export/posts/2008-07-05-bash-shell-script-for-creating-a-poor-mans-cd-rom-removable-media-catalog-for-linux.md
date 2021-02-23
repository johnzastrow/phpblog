---
 #  Bash shell script for creating a poor man’s CD-ROM (removable media) catalog for linux
categories:
  - Linux

---
#!/bin/sh  
\# jcz 2004-jan-12

\# assumes iso9660 CD-ROM  
mount -t iso9660 -r /dev/cdrom /mnt/cdrom

echo &#8220;Disc Mounted. Run this program, then grep keywords in the &#8220;  
echo &#8220;cdcatalogs directory to find which CD-ROM some file &#8220;  
echo &#8220;is on. &#8220;

\# makes the directory to store the catalog files  
mkdir cdcatalogs

\# runs volname (part of the eject program) to extract the volume label information  
cd=$(volname /dev/cdrom)

\# enter user defined CD label (something written on the CD itself)  
echo -n &#8220;Enter written CD-ROM label and any notes from the disc itself: &#8220;  
read labler

\# trims white space after the name always written out by volname  
cdshort=$(echo $cd | sed -e &#8216;s/[ntr ]*$//&#8217;)  
echo $cdshort  
echo $cdshort&#8221;_catalog.txt&#8221;  
disk=$cdshort&#8221;_catalog.txt&#8221;  
echo $disk  
echo $labler  
echo &#8220;Disk Volume Label: &#8220;$cdshort > $disk  
echo &#8220;Label and Notes on Disc: &#8221; $labler >> $disk  
echo &#8221; &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8221; >> $disk  
echo &#8220;&#8212;&#8212;&#8211; <<<<END DISC ENTRY>>> &#8212;&#8212;&#8212;&#8212;&#8221; >> $disk  
echo &#8221; &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8221; >> $disk  
echo &#8221; &#8221; >> $disk

\# by M$ Office products if needed  
ls -ghGR &#8211;full-time /mnt/cdrom | awk &#8216;{ print $1 &#8220;t&#8221; $3 &#8220;t&#8221;$4 &#8221; &#8221; $5 &#8220;t&#8221;$7 $8 $9 $10 $11 }&#8217;>> $disk

\# fixes the line endings for windows if you want read the catalogs directly in Notepad  
unix2dos $disk

\# moves file to consistent directory  
mv $disk cdcatalogs/

ls -lht cdcatalogs/

umount /mnt/cdrom  
\# ejects the disk when done to prepare for next disk  
eject