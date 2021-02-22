---
title: 'Linux.com: Bugs in your shell script?'
categories:
  - Linux

---
By: Larry Reckner  
Topics: Shell  
Subsection: Intermediate  
If your writing a shell script and want to watch exactly what is going on (very usefull for debugging purposes), add the line 

<pre>set -vx</pre>

in the beginning of the script. 

The shell script will then output what it&#8217;s doing so you can watch. 

This can also be done via command line by doing 

<pre>&lt;/p&gt;
&lt;p&gt;sh -x filename</pre>