---
title: Optimize all tables in a database, Part 2
categories:
  - Database

---
Ok, not being satisfied with my first exploration of a global &#8220;do something&#8221; mysql script I asked the community for help.

The result is posted below, and here are the links that got me here.  
<http://www.linuxquestions.org/questions/showthread.php?p=2668261#post2668261>  
<http://www.linuxforums.org/forum/linux-programming-scripting/85836-loop-within-loop-mysql-ops.html#post445403>{.broken_link}

Here is the final example script that optimizes (or replace optimize  
with your favorite command like backup, alter table to InnoDB, etc.)  
all tables in all databases on a server except the core mysql databases  
or others that you exclude.

#!/bin/sh  
MUSER=&#8221;USER&#8221;  
MPASS=&#8221;PASSWORD&#8221;  
MHOST=&#8221;localhost&#8221;  
MYSQL=&#8221;$(which mysql)&#8221;  
\# the Bs makes the output appear without the formatting  
\# and header row.  
\# Step 1: list all databases EXCEPT core mysql tables and others that can be added  
DBS=&#8221;$($MYSQL -u$MUSER -p$MPASS -Bse &#8216;show databases&#8217; | egrep -v &#8216;information_schema|mysql|test&#8217;)&#8221;

for db in ${DBS[@]}  
do

\# Step 2: list all tables in the databases  
echo &#8220;$MYSQL -u$MUSER -p$MPASS $db -Bse &#8216;show tables'&#8221;  
TABLENAMES=&#8221;$($MYSQL -u$MUSER -p$MPASS $db -Bse &#8216;show tables&#8217;)&#8221;  
echo &#8220;[START DATABASE]&#8221;  
echo &#8220;Database: &#8220;$db  
echo ${TABLENAMES[@]}

\# Step 3: perform an optimize (or other op) for all tables returned

for TABLENAME in ${TABLENAMES[@]}  
do  
echo $TABLENAME  
$MYSQL -u$MUSER -p$MPASS $db -Bse &#8220;optimize TABLE $TABLENAME;&#8221;  
done  
echo &#8220;[END DATABASE]&#8221;  
done