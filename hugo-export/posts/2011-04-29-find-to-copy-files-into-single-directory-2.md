---
title: find to copy files into single directory
author: John C. Zastrow
type: post
date: 2011-04-29T17:12:00+00:00
url: /2011/04/29/find-to-copy-files-into-single-directory-2/
categories:
  - Linux

---
Useful little one liners. This one makes copy of subset of dir/ and below based on finding files that match the criteria. In this case, I wanted all .doc files copied into a single place.

I run most of this stuff in Windows on Cygwin, so I use the:

[cce_bash]

<pre>-print0 | xargs -0
[/cce_bash]</pre>

part to handle the spaces in file and directory names.

[cce_bash]

<pre>find /cygdrive/f/dir1/ -name '*.doc' -print0 | xargs -0 cp -a --target-directory=/cygdrive/c/Temp --parents
[/cce_bash]</pre>