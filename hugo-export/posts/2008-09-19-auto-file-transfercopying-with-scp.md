---
title: Auto File transfer/copying with SCP
author: John C. Zastrow
type: post
date: 2008-09-19T18:45:49+00:00
url: /2008/09/19/auto-file-transfercopying-with-scp/
categories:
  - Uncategorized

---
Here is a 

<p class="MsoNormal">
  <font size="2" face="Arial"><span style="font-size: 10pt; font-family: Arial;">Here is a script (below) you can use to copy dump files between machines using scp from an<br /> automated script. Please see attached. The script usage is as<br /> follows:<o:p></o:p></span></font>
</p>

<p class="MsoNormal">
  <b><font size="2" face="Arial"><span style="font-weight: bold; font-size: 10pt; font-family: Arial;"><font face="Courier New">./auto_scp.sh&nbsp;&nbsp;<br /> local_file&nbsp;&nbsp; user@host:remote_folder&nbsp;&nbsp;<br /> user_password</font><o:p></o:p></span></font></b>
</p>

<p class="MsoNormal">
  <font size="2" face="Arial"><span style="font-size: 10pt; font-family: Arial;">or<font face="Courier New"><o:p></o:p></font></span></font>
</p>

<p class="MsoNormal">
  <b><font size="2" face="Arial"><span style="font-weight: bold; font-size: 10pt; font-family: Arial;"><font face="Courier New">./auto_scp.sh&nbsp;&nbsp;<br /> user@host:remote_file&nbsp;&nbsp; local_folder&nbsp;&nbsp;<br /> user_password</font><o:p></o:p></span></font></b>
</p>

<p class="MsoNormal">
  <font size="2" face="Arial"><span style="font-size: 10pt; font-family: Arial;">Example:<o:p></o:p></span></font>
</p>

<p class="MsoNormal">
  <font size="2" face="Arial"><span style="font-size: 10pt; font-family: Arial;"><font face="Courier New"><b>./auto_scp.sh&nbsp;&nbsp; dump.dmp&nbsp;&nbsp; <a title="mailto:oracle@ttdffxs-klamath.tetratech-ffx.com:/U01/oracle" href="mailto:oracle@ttdffxs-klamath.tetratech-ffx.com:/U01/oracle">oracle@hostname:/U01/oracle</a><br /> &nbsp;&nbsp;<oracle password></b></font><o:p></o:p></span></font>
</p>

and here is the script  
&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;

<pre>#!/usr/bin/expect -f&lt;/p&gt;
&lt;p&gt;# connect via scp&lt;br /&gt;spawn scp "[lindex $argv 0]" "[lindex $argv 1]" &lt;br /&gt;#############################################&lt;br /&gt;expect {&lt;br /&gt;-re ".*es.*o.*" {&lt;br /&gt;exp_send "yes\r"&lt;br /&gt;exp_continue&lt;br /&gt;}&lt;br /&gt;-re ".*sword.*" {&lt;br /&gt;exp_send "[lindex $argv 2]\r"&lt;br /&gt;}&lt;br /&gt;}&lt;br /&gt;interact&lt;br /&gt;</pre>