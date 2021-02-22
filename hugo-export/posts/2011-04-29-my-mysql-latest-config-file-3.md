---
title: My MySQL latest config file
categories:
  - Database
  - Linux

---
I never record this stuff and I always wish I did. So here&#8217;s a working MySQL config file that I&#8217;m using on a linux virtual machine with 2GB of memory. Notes and all so I don&#8217;t keep having to look stuff up.

\# MySQL config file for APPSRV VPS with 2GB of memory  
\# 25-March 25-2011  
\# jcz.  
\# For MySQL 5.1  
\# The following options will be passed to all MySQL clients  
[client]  
port&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; = 3306  
socket&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; = /var/lib/mysql/mysql.sock

<!--more-->

  
[mysqld_safe]  
log-error=/var/log/mysqld.log  
pid-file=/var/run/mysqld/mysqld.pid

\# Here follows entries for some specific programs

\# The MySQL server  
[mysqld]  
port&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; = 3306  
socket&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; = /var/lib/mysql/mysql.sock  
skip-external-locking = 1  
max\_allowed\_packet = 1M  
table\_open\_cache = 256  
socket&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; = /var/lib/mysql/mysql.sock  
user = mysql  
\# Disabling symbolic-links is recommended to prevent assorted security risks  
symbolic-links=0

\# Error log file (need dash in variable name)  
log-error = /var/log/mysql/mysqld.err 

\# Server directories  
\# leave commented out unless you know what you are doing  
\# basedir = /usr/  
datadir=/var/lib/mysql  
\# tmpdir = /home/poplar/mysql/tmp 

\# Log slow queries, time threshold set by &#8216;long\_query\_time&#8217;,  
slow-query-log = 1  
slow\_query\_log_file = /var/log/mysql/slow-queries.log  
log_output = FILE # 5.1 only  
long\_query\_time = 3

\# Enable this to get a log of all the statements coming from a client,  
\# this should be used for debugging only as it generates a lot of stuff  
\# very quickly  
#log = /var/log/mysql/queries.log 

\# Replication Master Server (default)  
\# binary logging is required for replication  
\# but we&#8217;re not going to replicate 

\# required unique id between 1 and 2^32 &#8211; 1  
\# defaults to 1 if master-host is not set  
\# but will not function as a master if omitted  
\# server-id&nbsp;&nbsp;&nbsp; = 1

\# Replication Slave (comment out master section to use this)  
\# Not used here &#8211; deleted &#8211; jcz &#8211; 25-mar-2011

\# Binary log and replication log file names prefix. We&#8217;ll binary log just to have it.  
log\_bin = /var/log/mysql/binary\_logs/server1-appsrv-bin 

\# Binary log format, see:  
\#  
\# http://dev.mysql.com/doc/refman/5.1/en/replication-sbr-rbr.html  
binlog_format = mixed # 5.1 only  
&nbsp;  
\# Binary log cache size  
binlog\_cache\_size = 1M 

\# Join buffer size for index-less joins  
join\_buffer\_size = 8M  
&nbsp;  
&nbsp;  
\# Set the default character set to utf8, but we&#8217;ll run with latin1 as it is default and OK  
\# leave commented out unless you know what you are doing  
\# default\_character\_set = utf8  
&nbsp;  
\# Set the server character set, but we&#8217;ll run with latin1 as it is default and OK  
\# leave commented out unless you know what you are doing  
\# character\_set\_server = utf8  
&nbsp;  
\# Set the default collation to utf8\_general\_ci  
\# leave commented out unless you know what you are doing  
\# default\_collation = utf8\_general_ci 

\# Set the names to utf8 when a client connects  
\# leave commented out unless you know what you are doing  
\# init\_connect = &#8216;SET NAMES utf8; SET sql\_mode = STRICT\_TRANS\_TABLES&#8217; 

\# Try number of CPU&#8217;s*2 for thread_concurrency  
thread_concurrency = 8

\# The maximum amount of concurrent sessions the MySQL server will  
\# allow. One of these connections will be reserved for a user with  
\# SUPER privileges to allow the administrator to login even if the  
\# connection limit has been reached.  
max_connections=200

\# Query cache, disabled for now  
\# query\_cache\_size = 0  
\# query\_cache\_limit = 2M&nbsp; 

\# Query cache is used to cache SELECT results and later return them  
\# without actual executing the same query once again. Having the query  
\# cache enabled may result in significant speed improvements, if your  
\# have a lot of identical queries and rarely changing tables. See the  
\# &#8220;Qcache\_lowmem\_prunes&#8221; status variable to check if the current value  
\# is high enough for your load.  
\# Note: In case your tables change very often or if your queries are  
\# textually different every time, the query cache may result in a  
\# slowdown instead of a performance improvement.  
query\_cache\_size=0

\# Maximum size for internal (in-memory) temporary tables. If a table  
\# grows larger than this value, it is automatically converted to disk  
\# based table This limitation is for a single table. There can be many  
\# of them.  
tmp\_table\_size=100M

\# Set the SQL mode to strict  
sql-mode=&#8221;STRICT\_TRANS\_TABLES,NO\_AUTO\_CREATE\_USER,NO\_ENGINE_SUBSTITUTION&#8221;

\# Don&#8217;t listen on a TCP/IP port at all. This can be a security enhancement,  
\# if all processes that need to connect to mysqld run on the same host.  
\# All interaction with mysqld must be made via Unix sockets or named pipes.  
\# Note that using this option without enabling named pipes on Windows  
\# (via the &#8220;enable-named-pipe&#8221; option) will render mysqld useless!  
\#  
#skip-networking

#\*** MyISAM Specific options

\# MyISAM options, see:  
\# http://dev.mysql.com/doc/refman/5.1/en/myisam-start.html  
\# reasonable defaults here, real values below:  
\# key\_buffer\_size = 256M  
\# read\_buffer\_size = 2M  
\# read\_rnd\_buffer_size = 8M  
\# myisam\_sort\_buffer_size = 128M  
\# bulk\_insert\_buffer_size = 64M  
\# myisam\_max\_sort\_file\_size = 10G  
\# myisam\_repair\_threads = 2  
\##### myisam\_recover\_options = DEFAULT 

\# The maximum size of the temporary file MySQL is allowed to use while  
\# recreating the index (during REPAIR, ALTER TABLE or LOAD DATA INFILE.  
\# If the file-size would be bigger than this, the index will be created  
\# through the key cache (which is slower).  
myisam\_max\_sort\_file\_size=100G

\# If the temporary file used for fast index creation would be bigger  
\# than using the key cache by the amount specified here, then prefer the  
\# key cache method.&nbsp; This is mainly used to force long character keys in  
\# large tables to use the slower key cache method to create the index.  
myisam\_sort\_buffer_size=172M

\# Size of the Key Buffer, used to cache index blocks for MyISAM tables.  
\# Do not set it larger than 30% of your available memory, as some memory  
\# is also required by the OS to cache rows. Even if you&#8217;re not using  
\# MyISAM tables, you should still set it to 8-64M as it will also be  
\# used for internal temporary disk tables.  
key\_buffer\_size=310M

\# Size of the buffer used for doing full table scans of MyISAM tables.  
\# Allocated per thread, if a full scan is needed.  
read\_buffer\_size=64K  
read\_rnd\_buffer_size=256K

\# This buffer is allocated when MySQL needs to rebuild the index in  
\# REPAIR, OPTIMZE, ALTER table statements as well as in LOAD DATA INFILE  
\# into an empty table. It is allocated per thread so be careful with  
\# large settings.  
sort\_buffer\_size=256K

\# Uncomment SOME of the following if you are using InnoDB tables  
\# leave commented out unless you know what you are doing  
#innodb\_data\_home_dir = /var/lib/mysql/  
\# this should likely be bigger  
innodb\_data\_file_path = ibdata1:50M:autoextend  
#innodb\_log\_group\_home\_dir = /var/lib/mysql/  
#innodb\_additional\_mem\_pool\_size = 20M  
\# Set ..\_log\_file_size to 25 % of buffer pool size  
#innodb\_log\_file_size = 64M  
#innodb\_log\_buffer_size = 8M  
#innodb\_flush\_log\_at\_trx_commit = 1  
#innodb\_lock\_wait_timeout = 50

#\*\\*\* INNODB Specific options \*\**

\# Additional memory pool that is used by InnoDB to store metadata  
\# information.&nbsp; If InnoDB requires more memory for this purpose it will  
\# start to allocate it from the OS.&nbsp; As this is fast enough on most  
\# recent operating systems, you normally do not need to change this  
\# value. SHOW INNODB STATUS will display the current amount used.  
innodb\_additional\_mem\_pool\_size=25M

\# If set to 1, InnoDB will flush (fsync) the transaction logs to the  
\# disk at each commit, which offers full ACID behavior. If you are  
\# willing to compromise this safety, and you are running small  
\# transactions, you may set this to 0 or 2 to reduce disk I/O to the  
\# logs. Value 0 means that the log is only written to the log file and  
\# the log file flushed to disk approximately once per second. Value 2  
\# means the log is written to the log file at each commit, but the log  
\# file is only flushed to disk approximately once per second.  
innodb\_flush\_log\_at\_trx_commit=1

\# The size of the buffer InnoDB uses for buffering log data. As soon as  
\# it is full, InnoDB will have to flush it to disk. As it is flushed  
\# once per second anyway, it does not make sense to have it very large  
\# (even with long transactions).  
innodb\_log\_buffer_size=8M

\# InnoDB, unlike MyISAM, uses a buffer pool to cache both indexes and  
\# row data. The bigger you set this the less disk I/O is needed to  
\# access data in tables. On a dedicated database server you may set this  
\# parameter up to 80% of the machine physical memory size. Do not set it  
\# too large, though, because competition of the physical memory may  
\# cause paging in the operating system.&nbsp; Note that on 32bit systems you  
\# might be limited to 2-3.5G of user level memory per process, so do not  
\# set it too high. You can set ..\_buffer\_pool_size up to 50 &#8211; 80 %  
\# of RAM but beware of setting memory usage too high.  
innodb\_buffer\_pool_size=400M

\# Size of each log file in a log group. You should set the combined size  
\# of log files to about 25%-100% of your buffer pool size to avoid  
\# unneeded buffer pool flush activity on log file overwrite. However,  
\# note that a larger logfile size will increase the time needed for the  
\# recovery process.  
innodb\_log\_file_size=120M

\# Number of threads allowed inside the InnoDB kernel. The optimal value  
\# depends highly on the application, hardware as well as the OS  
\# scheduler properties. A too high value may lead to thread thrashing.  
innodb\_thread\_concurrency=10

\# See http://dev.mysql.com/doc/refman/5.1/en/forcing-innodb-recovery.html  
\# If there is database page corruption, it is possible that the corruption  
\# might cause SELECT * FROM tbl_name statements or InnoDB  
\# background operations to crash or assert, or even cause InnoDB  
\# roll-forward recovery to crash. In such cases, you can use the  
\# innodb\_force\_recovery option to force the InnoDB storage engine to  
\# start up while preventing background operations from running, so  
\# that you are able to dump your tables. For example, you can add the  
\# following line to the [mysqld] section of your option file  
\# before restarting the server:  
#  
\# innodb\_force\_recovery = 4

[safe_mysqld]  
\# Log file  
&nbsp;err\_log = /var/log/mysql/safe\_mysqld.err 

[mysqldump]  
quick  
max\_allowed\_packet = 16M

[mysql]  
no-auto-rehash  
\# Remove the next comment character if you are not familiar with SQL  

[myisamchk]  
key\_buffer\_size = 128M  
sort\_buffer\_size = 128M  
read_buffer = 2M  
write_buffer = 2M

[mysqlhotcopy]  
interactive-timeout

\# 4. Disappearing MySQL host tables  
\# I&#8217;ve seen this happen a few times. Probably some kind of freakish MyISAM bug.  
\# Easily fixed with:  
\# /usr/local/bin/mysql\_install\_db 

\# Once you have corrupt InnoDB tables that are preventing your database from starting, you should follow this five step process:

\# Step 1: Add this line to your /etc/my.cnf configuration file:  
\# innodb\_force\_recovery = 4

\# Step 2: Restart MySQL. Your database will now start, but with innodb\_force\_recovery,  
#&nbsp; all INSERTs and UPDATEs will be ignored.  
\# Step 3: Dump all tables  
\# Step 4: Shutdown database and delete the data directory. Run mysql\_install\_db to create MySQL default tables  
\# Step 5: Remove the innodb\_force\_recovery line from your /etc/my.cnf file and restart the  
#&nbsp; database. (It should start normally now)  
\# Step 6: Restore everything from your backup

\# Now we can restart the database:

\# /usr/local/bin/mysqld_safe &

\# (Note: If MySQL doesn&#8217;t restart, keep increasing the innodb\_force\_recovery number until you get to innodb\_force\_recovery = 8)

\# Save all data into a temporary alldb.sql (this next command can take a while to finish):

\# mysqldump &#8211;force &#8211;compress &#8211;triggers &#8211;routines &#8211;create-options -uUSERNAME -pPASSWORD &#8211;all-databases > /usr/alldb.sql

\# Shutdown the database again:

\# mysqladmin -uUSERNAME -pPASSWORD shutdown

\# Delete the database directory. (Note: In my case  
#&nbsp; the data was under /usr/local/var. Your setup may be different.  
\# Make sure you&#8217;re deleting the correct directory)

\# rm -fdr /usr/local/var

\# Recreate the database directory and install MySQL basic tables

\# mkdir /usr/local/var  
\# chown -R mysql:mysql /usr/local/var  
\# /usr/local/bin/mysql\_install\_db  
\# chown -R mysql:mysql /usr/local/var

\# Remove innodb\_force\_recovery from /etc/my.cnf and restart database:

\# /usr/local/bin/mysqld_safe &

\# Import all the data back (this next command can take a while to finish):

\# mysql -uroot &#8211;compress < /usr/alldb.sql

\# And finally &#8211; flush MySQL privileges (because we&#8217;re also updating the MySQL table)

\# /usr/local/bin/mysqladmin -uroot flush-privileges

\# &#8211;

\# Note: For best results, add port=8819 (or any other random number)  
#&nbsp; to /etc/my.cnf before restarting MySQL and then add &#8211;port=8819 to the mysqldump command.  
\# This way you avoid the MySQL database getting hit with queries while the repair is in progress.



<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=3affc337-e9b4-8c90-be3e-3ee77533dd8c" />
</div>