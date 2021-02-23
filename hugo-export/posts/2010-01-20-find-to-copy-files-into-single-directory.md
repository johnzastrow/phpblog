---
 #  Find to copy files into single directory
categories:
  - Linux

---
Makes copy of subset of dir/ and below with files that match the criteria. It keeps the nested directory structure. Uses

<pre>-print0 | xargs -0

to handle spaces in Windows names</pre>

<pre>find /cygdrive/f/dir1/ -name '*.doc' -print0 | xargs -0 cp -a --target-directory=/cygdrive/c/Temp --parents</pre>