---
title: Reseting OpenSSH server keys on a server
categories:
  - Uncategorized

---
<div class="headline_area">
  <h1 class="entry-title">
    Ubuntu / Debian Linux Regenerate OpenSSH Host Keys
  </h1>
  
  <p class="headline_meta">
  </p></p>
</div>

<div style="float:right;margin-top:0px;margin-left:5px;">
  <a href="http://www.cyberciti.biz/faq/category/debian-ubuntu/" title="See all Debian/Ubuntu Linux related FAQ"><img src="http://files.cyberciti.biz/cbzcache/3rdparty/debianlogo.gif" border="0" /></a>
</div>

<span style="color: rgb(255, 0, 0);">Q.</span> How do I regenerate  
OpenSSH sshd server host keys stored in /etc/ssh/ssh\_host\_* files? Can I  
safely regenerate ssh host keys using remote ssh session as my existing  
ssh connections shouldn&#8217;t be interrupted?  
<span id="more-1115"></span>  
<span style="color: rgb(0, 153, 0);">A.</span> To regenerate keys you need to delete old files and reconfigure openssh-server. It is also safe to run following commands **over remote ssh session**. Your **existing session <span style="color: rgb(0, 153, 0);">shouldn&#8217;t be interrupted</span>**.

## Step # 1: Delete old ssh host keys



<pre># /bin/rm /etc/ssh/ssh_host_*</pre>

## Step # 2: Reconfigure OpenSSH Server

Now create a new set of keys, enter:  


<pre># dpkg-reconfigure openssh-server</pre>

  
Sample output:

<pre>Creating SSH2 RSA key; this may take some time ...
Creating SSH2 DSA key; this may take some time ...
Restarting OpenBSD Secure Shell server: sshd.</pre>



<pre>@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
@    WARNING: REMOTE HOST IDENTIFICATION HAS CHANGED!     @
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
IT IS POSSIBLE THAT SOMEONE IS DOING SOMETHING NASTY!
Someone could be eavesdropping on you right now (man-in-the-middle attack)!
It is also possible that the RSA host key has just been changed.
The fingerprint for the RSA key sent by the remote host is
f6:67:01:41:e6:20:06:4b:4b:fa:4b:c1:f1:45:45:e0.
Please contact your system administrator.
Add correct host key in /home/vivek/.ssh/known_hosts to get rid of this message.
Offending key in /home/vivek/.ssh/known_hosts:12
RSA host key for 202.54.xx.abc has changed and you have requested strict checking.
Host key verification failed.</pre>


 [1]: http://www.cyberciti.biz/faq/warning-remote-host-identification-has-changed-error-and-solution/