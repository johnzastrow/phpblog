---
 #  Changing run levels at boot time
categories:
  - Linux

---
As with most stories on this site, I use my stories to store notes on  
things that I keep needing to lookup and that might help others.

This one is how to change the default startup runlevel of a debian (via  
knoppix distribution). In this case I want it to stop booting into  
graphical mode, or boot into runlevel 3.

The &#8220;/etc/inittab&#8221; file tells init which runlevel to start the system at and describes the processes to be run at each runlevel.

So, according to

\# Default runlevel. The runlevels used by RHS are:  
\# 0 &#8211; halt (Do NOT set initdefault to this)  
\# 1 &#8211; Single user mode  
\# 2 &#8211; Multiuser, without NFS (The same as 3, if you do not have networking)  
\# 3 &#8211; Full multiuser mode  
\# 4 &#8211; unused  
\# 5 &#8211; X11  
\# 6 &#8211; reboot (Do NOT set initdefault to this)

the entry

id:3:initdefault:

would boot into multiuser mode, without X windows starting which is what I want.