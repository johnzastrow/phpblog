---
title: X windows with Cygwin
author: John C. Zastrow
type: post
date: 2008-07-06T01:33:04+00:00
url: /2008/07/05/x-windows-with-cygwin/
categories:
  - Linux

---
PC XStation Configuration  
Download the CygWin setup.exe from http://www.cygwin.com.

Install, making sure to select all the XFree86 optional packages.

If you need root access add the following entry into the /etc/securettys file on each server:

<client-name>:0  
From the command promot on the PC do the following:

set PATH=PATH;c:\cygwin\bin;c:\cygwin\usr\X11R6\bin  
XWin.exe :0 -query <server-name>  
The X environment should start in a new window.

Many Linux distributions do not start XDMCP by default. To allow XDMCP  
access from Cygwin edit the &#8220;/etc/X11/gdm/gdm.conf&#8221; file. Under the  
&#8220;[xdmcp]&#8221; section set &#8220;Enable=true&#8221;.

If you are starting any X applications during the session you will need  
to set the DISPLAY environment variable. Remember, you are acting as an  
XStation, not the server itself, so this variable must be set as  
follows:

DISPLAY=<client-name>:0.0; export DISPLAY