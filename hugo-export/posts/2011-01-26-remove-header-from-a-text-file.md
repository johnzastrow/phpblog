---
title: Remove header from a text file
categories:
  - Database
  - GIS
  - Linux
  - Uncategorized

---
I&#8217;m processing some Darwin-schema biodiversity text files in preparation for GISing them and I need to trim the headers from the tops of the files before importing them to the database. Of course, *NIX command line utilities have been my friend here. The following will trim the first line off the file. Just up the number to trim more lines off. I&#8217;m using Cygwin on Windows to run these.

<pre>sed '1d' file.txt # trims the line then replaces file.txt, so be careful.

awk 'FNR&gt;1{print}' file.txt &gt; newfile.txt # I ended up using this to be safe. It was easier to test.

tail -n+2 /path/to/file &gt; /path/to/output # can be tested with echo -e "foo\nbar\nbaz" | tail -n+2</pre>

Also in my case, I wanted column headers left in file, and thankfully the headers were pretty much the same across all the files. So I grep searched in the directory with all the files for the name of the first uniquely worded column and asked grep to also return the line numbers of where it found that word. Then I use that number (minus one) to put into my header deleting command.

<pre>&gt; grep -n 'Institution' *
HerpnetUtahBottomHalfProviders_January25_2010.txt:35:Institution	Collection	Catalog number text ...
HerpnetUtahTopHalfProviders_January25_2010.txt:27:Institution	Collection	Catalog number text...</pre>

Then, for example, I would use

<pre>awk 'FNR&gt;34{print}' HerpnetUtahBottomHalfProviders_January25_2010.txt &gt; HerpnetUtahBottomHalfProviders_January25_2010_trimmed.txt</pre>

I love using Excel to craft a slew of commands then copy/paste them into the shell to batch process tens of files in my case.