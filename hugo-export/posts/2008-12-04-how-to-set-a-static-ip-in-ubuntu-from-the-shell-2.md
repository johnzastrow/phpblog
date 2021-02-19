---
title: How to set a static IP in Ubuntu from the shell
author: John C. Zastrow
type: post
date: 2008-12-05T00:49:06+00:00
url: /2008/12/04/how-to-set-a-static-ip-in-ubuntu-from-the-shell-2/
categories:
  - Linux

---
Edit  


<pre>&lt;br /&gt;
/etc/network/interfaces</pre>

and adjust it to your needs (in this example setup I will use the IP address 192.168.0.100):  


<pre># This file describes the network interfaces available on your system&lt;br /&gt;
# and how to activate them. For more information, see interfaces(5).</pre>

<pre># The loopback network interface&lt;br /&gt;
auto lo&lt;br /&gt;
iface lo inet loopback</pre>

<pre># This is a list of hotpluggable network interfaces.&lt;br /&gt;
# They will be activated automatically by the hotplug subsystem.&lt;br /&gt;
mapping hotplug&lt;br /&gt;
script grep&lt;br /&gt;
map eth0</pre>

<pre>&lt;br /&gt;
# The primary network interface&lt;br /&gt;
auto eth0&lt;br /&gt;
iface eth0 inet static&lt;br /&gt;
address 192.168.0.100&lt;br /&gt;
netmask 255.255.255.0&lt;br /&gt;
network 192.168.0.0&lt;br /&gt;
broadcast 192.168.0.255&lt;br /&gt;
gateway 192.168.0.1</pre>

Then do

<pre>sudo /etc/init.d/networking restart</pre>

to restart the network.