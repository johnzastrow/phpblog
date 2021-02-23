---
 #  Search remotely and send the results to local machine
categories:
  - Linux

---
If you want to grep (search) through a log file while you&#8217;re ssh&#8217;d in  
to a server and then get that output to yourself on your workstation. I  
usually do &#8220;grep &#8230; > ~/file.txt&#8221; and then scp it over. 

But you can also do:

ssh remotehost -l remoteuser &#8220;grep regexpr logfile&#8221; > localfilename

Or if you are already on the remote but want the file to end up locally:

grep &#8230; | ssh localhost cat \>file.txt

~ from the gang at Milwaukee LUG