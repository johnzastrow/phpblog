---
title: Wget examples
author: John C. Zastrow
type: post
date: 2013-02-20T14:30:50+00:00
url: /2013/02/20/wget-examples/
categories:
  - Data processing
  - Linux
  - water quality
  - Web

---
I keep having to Google wget incantations. So, I&#8217;m going to just write some common ones down here. The spell at the moment is below and can be used with <a title="Importing EPA WQX Domains into MySQL Tables" href="http://northredoubt.com/n/2013/02/19/importing-epa-wqx-domains-into-mysql-tables/" target="_blank">my previous post</a> about processing EPA WQX/STORET domain values into useful tables:

<pre>wget -r -c -np -l2 -H -nd -A.zip,.xslx -erobots=off -o download.log --user-agent="Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008092416 Firefox/3.0.3" http://www.epa.gov/storet/wqx/wqx_getdomainvalueswebservice.html</pre>

This is derived from the following notes:

  * if you omit ‘-A.mid’ it would just download everything.
  * -l1 means 1 level deep.
  * -np means ignore parent links.
  * -r means recursively download links.
  * -nc means don’t download stuff that is already downloaded (if you want to resume later, or check for new files some other time)
  * If the links are to different subdomains, you can specify host-spanning using the -H option,
  * e.g. if bar.html contains links to files on host src.foobar.com, it won&#8217;t fetch them unless you specify -H.
  * It&#8217;s also a good idea in that case to limit spanning to a domain using -D foobar.com.
  * The -w option waits 30 seconds between retrievals. Not used here.
  * You can also use &#8211;limit-rate=20k to limit the download speed to 20kb per second.
  * -nd, &#8211;no-directories or don&#8217;t create directories as files are found on the server. Just stick everything into a single directory.
  * -c Continue the Incomplete Download Using wget -c
  * &#8211;user-agent Some websites can disallow you to download its page by identifying that the user agent is not a browser. So you can mask the user agent by using –user-agent options and show wget like a browser as shown below.

<pre>--user-agent="Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008092416 Firefox/3.0.3" URL-TO-DOWNLOAD</pre>

  * If the internet connection has problem, and if the download file is large there is a chance of failures in the download. By default wget retries 20 times to make the download successful. If needed, you can increase retry attempts using –tries option as shown below.

<pre>wget --tries=75 DOWNLOAD-URL</pre>

  *  Log messages to a log file instead of stderr Using wget -o. When you wanted the log to be redirected to a log file instead of the terminal.

<pre>wget -o download.log DOWNLOAD-URL</pre>

Many sites now employ a means of blocking robots like wget from accessing their files. Most of the time they use .htaccess to do this. So a permanent workaround has wget mimic a normal browser. _Just add the -d option. Like: $ wget -O/dev/null -d http://www.askapache.com_ If you run the command at the top, you&#8217;ll get a directory of files as below

<pre>$ ls -lht
total 1.6M
-rw-r--r-- 1 john.zastrow Domain Users  28K Feb 20 09:25 download.log
-rw-r--r-- 1 john.zastrow Domain Users  77K Feb 20 09:16 All.zip
-rw-r--r-- 1 john.zastrow Domain Users  33K Feb 20 09:16 Organization.zip
-rw-r--r-- 1 john.zastrow Domain Users 101K Feb 20 09:16 Characteristic.zip
-rw-r--r-- 1 john.zastrow Domain Users 6.7K Feb 20 09:16 MeasureUnit.zip
----- snip ------</pre>

&nbsp;

<pre>wget --referer="http://www.google.com" --user-agent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6" --header="Accept:
text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5" --header="Accept-Language: en-us,en;q=0.5" --header="Accept-Encoding: gzip,deflate"
--header="Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" --header="Keep-Alive: 300" -dnv http://www.askapache.com/sitemap.xml</pre>

**The reading**

  * http://www.thegeekstuff.com/2009/09/the-ultimate-wget-download-guide-with-15-awesome-examples/
  * http://www.askapache.com/linux/wget-header-trick.html