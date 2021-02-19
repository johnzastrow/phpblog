---
title: Benchmarking MySQL
author: John C. Zastrow
type: post
date: 2011-04-22T21:10:46+00:00
url: /2011/04/22/benchmarking-mysql/
categories:
  - Database
  - Uncategorized

---
So I&#8217;m trying to figure which old machine to turn into a little mySQL number cruncher. So, I&#8217;m going to do some clean installs of Ubuntu server on each and run this little script (with the same my.cnf) and see how they fair. Perhaps you will this useful, run it a few times.

[cce_bash]

#!/bin/sh  
\# jcz 2011-April-22  
#  
\# This script will time your MySQL database in a repeatable way  
#  
\# Date and other variables pretty self explanatory, S is seconds  
\# date format is currently YYYYMMDD_HHMMSS  
    dater=$(date +%Y%m%d_%H%M%S)  
    dayer=$(date +%a)  
    myhost=$(hostname)  
    directory=$(pwd)  
    outfile=&#8221;slapout.txt&#8221;

\# THE MYSQL USER  
    super=&#8221;username&#8221;

\# THE MYSQL SUPERPWORD  
    superword=&#8221;password&#8221;

\# THE MYSQL HOSTNAME or IP.  
    hoster=&#8221;localhost&#8221;

echo &#8220;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212; BEGIN &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;&#8221; >> $outfile  
date >> $outfile  
echo $myhost >> $outfile  
echo $directory >> $outfile

\# COPY THE COMMAND BELOW  
mysqlslap -u$super -p$superword  -h$hoster -v &#8211;concurrency=1 &#8211;iterations=2 &#8211;number-int-cols=4 &#8211;number-char-cols=5 &#8211;auto-generate-sql &#8211;auto-generate-sql-secondary-indexes=3 &#8211;engine=myisam,innodb  &#8211;auto-generate-sql-add-autoincrement &#8211;auto-generate-sql-load-type=mixed  &#8211;number-of-queries=2 >> $outfile

 echo &#8220;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;..&#8221; >> $outfile  
 # PASTE THE COMMAND BELOW BETWEEN THE QUOTES OR EDIT BOTH. I CAN&#8217;T FIND ANOTHER WAY TO RECORD IT  
echo &#8220;mysqlslap -u$super -p$superword  -h$hoster -v &#8211;concurrency=1 &#8211;iterations=2 &#8211;number-int-cols=4 &#8211;number-char-cols=5 &#8211;auto-generate-sql &#8211;auto-generate-sql-secondary-indexes=3 &#8211;engine=myisam,innodb  &#8211;auto-generate-sql-add-autoincrement &#8211;auto-generate-sql-load-type=mixed  &#8211;number-of-queries=2&#8221; >> $outfile  
echo &#8220;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;..&#8221; >> $outfile  
echo &#8220;The above command was executed to produce the results above it.&#8221; >> $outfile  
echo &#8220;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212; END &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;&#8221; >> $outfile  
echo &#8220;&#8221; >> $outfile  
echo &#8220;&#8221; >> $outfile  
echo &#8220;&#8221; >> $outfile

[/cce_bash]

The above script makes output like below

<!--more-->

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212; BEGIN &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;  
Fri Apr 22 17:05:15 EDT 2011  
monitor  
/home/jcz  
Benchmark  
        Running for engine myisam  
        Average number of seconds to run all queries: 0.000 seconds  
        Minimum number of seconds to run all queries: 0.000 seconds  
        Maximum number of seconds to run all queries: 0.000 seconds  
        Number of clients running queries: 1  
        Average number of queries per client: 2

Benchmark  
        Running for engine innodb  
        Average number of seconds to run all queries: 0.045 seconds  
        Minimum number of seconds to run all queries: 0.041 seconds  
        Maximum number of seconds to run all queries: 0.050 seconds  
        Number of clients running queries: 1  
        Average number of queries per client: 2

&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;..  
mysqlslap -u&#8230; -p&#8230;  -hlocalhost -v &#8211;concurrency=1 &#8211;iterations=2 &#8211;number-int-cols=4 &#8211;number-char-cols=5 &#8211;auto-generate-sql &#8211;auto-generate-sql-secondary-indexes=3 &#8211;engine=myisam,innodb  &#8211;auto-generate-sql-add-autoincrement &#8211;auto-generate-sql-load-type=mixed  &#8211;number-of-queries=2  
&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;..  
The above command was executed to produce the results above it.  
&#8212;&#8212;&#8212;&#8212;&#8212;&#8212; END &#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=d54ad172-51f5-87b0-9511-d9bb15393ec4" alt="" />
</div>