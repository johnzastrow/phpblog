---
title: Simple netstat
author: John C. Zastrow
type: post
date: 2008-07-06T01:32:20+00:00
url: /2008/07/05/simple-netstat/
categories:
  - Linux

---
<pre>netstat -tln | fgrep :10000 </pre>

on the box would tell you if the app is listening on port 10000. (And in  
particular if it is listening to port 10000 on all interfaces,  
or at least 127.0.0.1.