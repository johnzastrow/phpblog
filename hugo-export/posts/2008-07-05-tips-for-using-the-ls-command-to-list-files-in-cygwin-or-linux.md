---
 #  Tips for using the ls command to list files in Cygwin or Linux
categories:
  - Linux

---
Classify


* / directory  
\* \* executable 

Code: ls -F  
directory/ me.jpeg script.sh*

ls &#8211;color=tty

Will color the &#8216;ls&#8217; output. Directories are blue, regular files stay black (or white) and executable files are green.

Make an Alias of your prefered method.

Example:

alias ls=&#8217;ls &#8211;color=tty &#8211;classify&#8217;

List only directories

ls -d */

Will list only dentries ended by a &#8220;/&#8221;, and with the &#8220;-d&#8221; option, will not descend into the next level of directory.