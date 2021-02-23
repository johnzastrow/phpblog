---
 #  Simple netstat
categories:
  - Linux

---
<pre>netstat -tln | fgrep :10000 </pre>

on the box would tell you if the app is listening on port 10000. (And in  
particular if it is listening to port 10000 on all interfaces,  
or at least 127.0.0.1.