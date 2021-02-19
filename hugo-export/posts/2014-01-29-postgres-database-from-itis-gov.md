---
title: Postgres database from itis.gov
author: John C. Zastrow
type: post
date: 2014-01-29T20:22:30+00:00
url: /2014/01/29/postgres-database-from-itis-gov/
categories:
  - Data processing
  - Database
  - Uncategorized

---
This might save you some head aches. The postgresql database dump of the taxonomic universe (according to the USGS) from <a href="http://www.itis.gov/" target="_blank" class="broken_link">http://www.itis.gov/</a> is provided in a latin1 character encoding (specifically it tries to create a database as ENCODING = &#8216;LATIN1&#8217; LC\_COLLATE = &#8216;en\_US.ISO8859-1&#8217; LC\_CTYPE = &#8216;en\_US.ISO8859-1&#8217; ). In order to bring this dump into a modern Postgres instance you&#8217;ll likely have to deal with the encoding being different in the dump versus your system. Rather than changing the locale of your entire database (which is likely UTF-8). It&#8217;s easier to change the encoding of the SQL file they give you.

Using this excellent reference:  
<a href="http://stackoverflow.com/questions/64860/best-way-to-convert-text-files-between-character-sets" target="_blank">http://stackoverflow.com/questions/64860/best-way-to-convert-text-files-between-character-sets</a>

I went right for iconv and this worked for me on my ubuntu 12.04 (after installing recode which might have brought in some additional encodings that weren&#8217;t there before).

<pre class="lang:sh decode:true crayon-selected">iconv -f latin1 -t UTF-8 ITIS.sql &gt; ITIS-utf8.sql</pre>

Then you have to edit the SQL dump file to remove references that enforce the encoding so that the database will just use its defaults when you load it.