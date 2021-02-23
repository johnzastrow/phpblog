---
 #  'Handy shell file lister for cygwin or *NIX'
categories:
  - Uncategorized
tags:
  - 

---
This tip is useful for any system with a useful implementaion of 

<pre>ls, wc, and awk</pre>. However, some options may need to be modified. For example, the 

<pre>ls</pre> options work best on linux, though they suffice on my cygwin install on Windows when my username does not have a space in it

The commands for running this trick usefully on cygwin/windows is:

<pre>ls -ghGR --full-time | awk '{ print $1"\t" $3 "\t" $4 "\t" $7 $8 $9 $10 $11 $12 }' | unix2dos &gt; filelist.txt && wc -l filelist.txt &gt;&gt; filelist.txt</pre>

to produce the following listing:

[snip]  
<font color="#009900"><small><font face="Courier New">total <br />-rwx&#8212;&#8212;+ 16K 2008-06-09 Export_Output.shp.xml<br />drwx&#8212;&#8212;+ 0 2008-06-24 java<br />drwx&#8212;&#8212;+ 0 2008-06-24 licenses<br />-rwx&#8212;&#8212;+ 42K 2008-05-29 openoffice.org-activex.cab<br />-rwx&#8212;&#8212;+ 1.8M 2008-05-29 openoffice.org-base.cab<br />-rwx&#8212;&#8212;+ 18M 2008-05-29 openoffice.org-core05.cab<br />-rwx&#8212;&#8212;+ 28M 2008-05-29 openoffice.org-core06.cab<br />-rwx&#8212;&#8212;+ 3.7M 2008-05-29 openoffice.org-core07.cab<br />-rwx&#8212;&#8212;+ 2.4M 2008-05-29 openoffice.org-writer.cab<br />-rwx&#8212;&#8212;+ 37K 2008-05-29 openoffice.org-xsltfilter.cab<br />-rwx&#8212;&#8212;+ 4.2M 2008-05-29 openofficeorg24.msi<br />drwx&#8212;&#8212;+ 0 2008-06-24 readmes<br />-rwx&#8212;&#8212;+ 217 2008-05-29 setup.ini<br />-rwx&#8212;&#8212;+ 500K 2008-06-19 stormwater.mdb</p> 

<p>
  ./java: <br />total <br />-rwx&#8212;&#8212;+ 16M 2008-01-15 jre-6u4-windows-i586-p.exe
</p>

<p>
  ./licenses: <br />total
</p>

<p>
  158 filelist.txt</font></small></font>
</p>