---
 #  Another Linux Web MySQL Backup Script
categories:
  - Linux

---
I found this on on the nixcraft craft. Looks pretty good to me. Similar  
in functionality to my other script posted here. I&#8217;m going to poach  
some concepts from here to make a script that will auto-optimize all  
tables in all databases on the mysql server.

#!/bin/sh  
##################  
\## jcz 17-feb-2007  
\## copied from <http://www.cyberciti.biz/tips/>  
\## how-to-backup-mysql-databases-web-server-  
\## files-to-a-ftp-server-automatically.html  
##############################################  
\## System + MySQL backup script  
\## Full backup day &#8211; Sun (rest of the day do incremental backup)  
\## Copyright (c) 2005-2006 nixCraft  
\## This script is licensed under GNU GPL version 2.0 or above  
\## Automatically generated by <http://bash.cyberciti.biz/backup/wizard-ftp-script.php>  
\## Make full backup every Sunday night  
\## i.e. backup everything every Sunday  
\## Next backup only those files that  
\## have been modified since the full  
\## backup (incremental backup)  
##################################################  
\## * This is a seven-day backup cycle.  
\## * It will store data as follows:  
\## * /home/nixcraft/full/mm-dd-yy/files &#8211; Full backup  
\## * /home/nixcraft/incremental/mm-dd-yy/files &#8211; Incremental backup  
\## * 1. First script will collect all data from both  
\## * MySQL database server and from file system to  
\## * temporary directory called /backup using tar command  
\## * 2. Next, script will login to ftp server and  
\## * create a directory structure as discussed above  
\## * 3. Script will dump all files from /backup to ftp server  
\## * 4. Script will remove temporary backup from /backup  
\## * 5. Script will send you an email notification  
\## * if ftp backups failed due to any reason.  
##  
\## * You must have following command installed:  
##  
\## * ncftp ftp client  
\## * mysqldump command  
\## * GNU tar command  
###########################################  
\# ———————————————————————  
\### System Setup ###  
DIRS=”/home /etc /var/www”  
BACKUP=/tmp/backup.$$  
INCFILE=”/root/tar-inc-backup.dat”  
FULLBACKUP=”Sun”  
\### MySQL Setup ###  
MUSER=”admin”  
MPASS=”mysqladminpassword”  
MHOST=”localhost”  
MYSQL=”$(which mysql)”  
MYSQLDUMP=”$(which mysqldump)”  
GZIP=”$(which gzip)”  
\### FTP server Setup ###  
FTPD=”/home/vivek/incremental”  
FTPU=”vivek”  
FTPP=”ftppassword”  
FTPS=”208.111.11.2?  
NCFTP=”$(which ncftpput)”  
\### Other stuff ###  
EMAILID=”admin@theos.in”  
\### Start Backup for file system ###  
[ ! -d $BACKUP ] && mkdir -p $BACKUP || :  
\### See if we want to make a full backup ###  
if [ “$DAY” == “$FULLBACKUP” ]; then  
FTPD=”/home/vivek/full”  
FILE=”fs-full-$NOW.tar.gz”  
tar -zcvf $BACKUP/$FILE $DIRS  
else  
FILE=”fs-i-$NOW-$i.tar.gz”  
tar -g $INCFILE -zcvf $BACKUP/$FILE $DIRS  
fi  
\### Start MySQL Backup ###  
\# Get all databases name  
DBS=”$($MYSQL -u $MUSER -h $MHOST -p$MPASS -Bse ’show databases’)”  
for db in $DBS  
do  
$MYSQLDUMP -u $MUSER -h $MHOST -p$MPASS $db | $GZIP -9 > $FILE  
done  
\### Dump backup using FTP ###  
#Start FTP backup using ncftp  
ncftp -u”$FTPU” -p”$FTPP” $FTPS<  
mkdir $FTPD  
mkdir $FTPD/$NOW  
cd $FTPD/$NOW  
lcd $BACKUP  
mput *  
quit  
EOF  
\### Find out if ftp backup failed or not ###  
if [ &#8220;$?&#8221; == &#8220;0&#8221; ]; then  
rm -f $BACKUP/*  
else  
T=/tmp/backup.fail  
echo “Hostname: $(hostname)” >>$T  
echo “Backup failed” >>$T  
mail -s “BACKUP FAILED” “$EMAILID” <$T  
rm -f $T  
fi