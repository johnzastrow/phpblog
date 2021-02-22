---
 #  File listing ditties
categories:
  - Linux

---
Here are some simple bash scripts to list files into a text files that can be used to catalog stuff. Most of the time I use the last one.   
[cce_bash]

filer=$(find . -mtime -1)  
sizer=$(ls -lah $filer | awk &#8216;{ print $5&#8243;\t&#8221; $6&#8243;\t&#8221; $7&#8243;\t&#8221; $8&#8243;\t&#8221; $9&#8243;\t\n&#8221; }&#8217;)  
echo $sizer

[/cce_bash]

or this one

[cce_bash]  
ls -ghG &#8211;full-time | awk &#8216;{ print $1&#8243;\t&#8221; $3 &#8220;\t&#8221; $4 &#8220;\t&#8221; $7 $8 $9 $10 $11 $12 &#8220;\n&#8221; }&#8217; > files.txt  
cat files.txt  
[/cce_bash]  
The script above makes output as follows. The extra lines just made it easier for me to read. This one will output files with spaces in the name by removing the spaces (lumping the words together). If you don&#8217;t like that, just put the &#8221; &#8221; between $7 $8 $9 etc. above.

> <pre>[john.zastrow@appsrv ~]$ cat files.txt
total</pre>
> 
> <pre>drwxr-xr-x.     4.0K    2011-03-24      Desktop</pre>
> 
> <pre>drwxr-xr-x.     4.0K    2011-03-24      Documents</pre>
> 
> <pre>drwxr-xr-x.     4.0K    2011-03-24      Downloads</pre>
> 
> <pre>-rwxrwxrwx      126     2011-04-29      filer1.sh</pre>
> 
> <pre>-rwxrwxrwx      158     2011-04-29      filer2.sh</pre>
> 
> <pre>-rwxrwxrwx      123     2011-04-29      filer3.sh</pre>
> 
> <pre>-rw-rw-r--      0       2011-04-29      files.txt</pre>
> 
> <pre>-rwxrwxrwx      73      2011-04-29      inter.sh</pre>

<span style="color: #000000;">Then this script</span>

<span style="color: #000000;"> </span>

<div id="_mcePaste" class="mcePaste" style="position: absolute; width: 1px; height: 1px; overflow: hidden; top: 0px; left: -10000px;">
  ?
</div>

[cce_bash]  
#!/bin/sh  
stat &#8211;printf &#8220;%F \t %y \t %z \t %s \t %N\n&#8221; * >> statfile.txt  
cat statfile.txt

[/cce_bash]  
<span style="color: #ff6600;"><br /> </span>

 is just a little different and produces the following output. Notice that in both script I&#8217;m using tabs so these text files should come into a spreadsheet program nicely as below. Also notice the use of &#8211;printf so that I can embed the tabs right into stat&#8217;s output thereby more gracefully handling filenames with spaces in them (plus I quote them for good measure). A good use of this would be to combine find with it.

[<img loading="lazy" class="alignnone size-medium wp-image-159" title="stater_output" src="http://northredoubt.com/n/wp-content/uploads/2011/04/stater_output-300x101.png" alt="" width="300" height="101" srcset="http://northredoubt.com/n/wp-content/uploads/2011/04/stater_output-300x101.png 300w, http://northredoubt.com/n/wp-content/uploads/2011/04/stater_output.png 869w" sizes="(max-width: 300px) 100vw, 300px" />][1]

 [1]: http://northredoubt.com/n/wp-content/uploads/2011/04/stater_output.png