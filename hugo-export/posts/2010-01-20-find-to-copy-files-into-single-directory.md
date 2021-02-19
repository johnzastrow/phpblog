---
title: Find to copy files into single directory
author: John C. Zastrow
type: post
date: 2010-01-20T21:49:16+00:00
url: /2010/01/20/find-to-copy-files-into-single-directory/
categories:
  - Linux

---
Makes copy of subset of dir/ and below with files that match the criteria. It keeps the nested directory structure. Uses

<pre>-print0 | xargs -0

to handle spaces in Windows names</pre>

<pre>find /cygdrive/f/dir1/ -name '*.doc' -print0 | xargs -0 cp -a --target-directory=/cygdrive/c/Temp --parents</pre>