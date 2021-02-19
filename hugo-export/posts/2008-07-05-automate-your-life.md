---
title: Automate your life
author: John C. Zastrow
type: post
date: 2008-07-06T01:17:21+00:00
url: /2008/07/05/automate-your-life/
categories:
  - Linux

---
_**What is crontab?**_



If you&#8217;ve worked with Perl  
scripts I&#8217;m sure you&#8217;ve heard or seen the words &#8220;cron&#8221;,

&#8220;crontab&#8221;, or &#8220;cron job&#8221; before. If not, you&#8217;ll learn  
something new today! 

The

crontab command allows you to tell your server to execute a file at a specific

time, as often as you want &#8211; like once a day or once a minute. Most commonly,  
crontab

is used to execute a cgi script to perform a certain task repeatedly rather than

doing it manually. Saves a lot of time!



_NOTE:_ many hosting  
companies disable crontab on their hosting accounts because

it is often abused. Using it to repeatedly execute a file takes up precious cpu

time and if misused can slow down a server immensely. However, if you talk to  
your

hosting company and let them know what file you are going to run they more than

likely will be happy to enable crontab on your system. If they won&#8217;t, then you  
might want to think about getting a dedicated server&#8230;



_**Where do I start?**_



To use crontab, you have  
to be able to telnet into your server. This is accomplished

in Windows by going to Start->Run and typing in &#8220;telnet yourdomain.com&#8221;  
and hitting

&#8220;OK&#8221;. A new window will pop up and you will have to put in your  
username and password.

If you normally use an FTP client, usually it&#8217;s the same username and password.



If successful. you will  
then get a command prompt: $



First, you can see the  
crontab usage info by typing in &#8220;crontab&#8221; and hitting return.

Here&#8217;s what it looks like on my server:



usage: crontab [-u user]  
file

crontab [-u user] { -e | -l | -r }

-e (edit user&#8217;s crontab)

-l (list user&#8217;s crontab)

-r (delete user&#8217;s crontab)

So, if you type:

crontab -l

you will get a list of the crontab jobs already running on your system. Try it  
out. You probably don&#8217;t have any running so you will get an empty list&#8230;



_**How do I set up a  
crontab job?**_

While you can edit the crontab file directly through telnet, I&#8217;ve found that the  
easiest way for a beginner to start a crontab job is to create a text file  
containing your crontab instructions, upload it to your main directory, telnet  
into your system, and then just type:



crontab myfile.txt



and the crontab job will  
be created.

**_So what do I put in the text file? What is the syntax?_**



This text file will  
minimally only have to have one line containing the information

for your cron job. Here is a run down of the syntax:

0 1 \* \* * /path/to/cgi-bin/yourscript.cgi

| | | | |

| | | | |\___\___\___\___\____ day of week

| | | |\___\___\___\___\___\___ month of year

| | |\___\___\___\___\___\_____ day of month

| |\___\___\___\___\___\___\____ hour of day

|\___\___\___\___\___\___\___\___ minute of hour



The * in the above example  
basically means &#8220;every&#8221;. So, in this example the script would execute  
\*every\* month, \*every\* day of the week, \*every\* day of the month, and then ONLY  
at hour 1 of the day. So &#8211; this script would execute once a day at 1 am in the  
morning.



Say you wanted to execute  
it 4 times a day, you would type in:



0 1,7,13,19 \* \* * /path/to/cgi-bin/autocron.cgi



This executes autocron.cgi  
four times a day about every 6 hours. Notice that

you can use commas to add in more times &#8211; but always keep the spaces to  
delineate

the time frames.



Another example, to  
execute autocron.cgi twice a month:



0 1 1,15 \* \* /path/to/cgi-bin/autocron.cgi



This line would execute  
the file on the 1st and 15th of the month at 1AM.



**_Can I run multiple  
crontab jobs?_**



In a nutshell &#8211; YES! Just  
add multiple lines to the text file using the syntax above for every

script that you would like to run. Make sure that the paths to the scripts are

correct and you&#8217;ve double checked your time settings.

_**How can I tell that it&#8217;s working?**_



Simple, after you have  
executed the text file with your one line crontab, just

type:



crontab  
-l

At your command prompt and you will see something like this:

\# (cronjob.txt installed on Tue Apr 11 21:19:12 2000)

\# (Cron version &#8212; $Id: crontab.c,v 2.13 1994/01/17 03:20:37 vixie Exp $)

0 1 \* \* * /path/to/cgi-bin/yourscript.cgi



All of the running jobs  
will be listed.



_**Can I edit my  
crontab file through telnet?**_



Yes, however, I prefer to  
just delete the current crontab file and create a new

one with a new text file. Just type:



crontab  
-e

and your crontab file editor will pop up and you can edit the file. Some telnet

clients make it hard to edit this file though &#8211; which is why I just delete

and recreate my crontab file.

_**How do I delete a crontab file?**_



This is easy! At the  
telnet prompt, type:



crontab  
-r

and the crontab file will be completely deleted. You can check this by using the

&#8220;crontab -l&#8221; command. And of course, you can recreate your file by  
typing

&#8220;crontab myfile.txt&#8221;. (or whatever you named the text file containing  
your

crontab lines)