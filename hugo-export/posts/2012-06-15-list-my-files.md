---
 #  List my files
categories:
  - Data processing
  - Linux

---
About three times a year I need to make a listing of files in a directory. Usually this is because I need to do something to them and I need a checklist. Or I just need to tell someone what files are there.

So, back in 2002 I made this little script. Enjoy.

<pre class="lang:bash decode:1 " >#!/bin/sh
# jcz 2012-June-16
# listfiles.sh

# Variables pretty self explanatory, S is seconds
namer=$(hostname)
startdir=$(pwd)

echo "* WELCOME TO THE FILELISTING SCRIPT FOR THE HOSTNAME" $namer
echo "* THE CORRECT USAGE IN A *NIX (CYWGIN) SHELL ENVIRONMENT WOULD BE SOMETHING LIKE"
echo "* listfiles.sh &gt; /cygdrive/c/prvi/metlist.txt"
echo "* --------------------------------------------------"
echo "* Open this file in a spreadsheet program like Excel"
echo "* and use a pipe ( | ) delimited text format"
echo "* RESULTS WILL BE SAVED TO" $startdir
echo "* --------------------------------------------------"
echo ""
echo "Directories space use:"

# display directory disk usage drilling down one level from where the script is run
du -h --max-depth=1
echo " --------------------------------------"
echo ""

# Sometimes I care what all the directories are
echo "All Directories are:"
echo " --------------------------------------"
echo ""
echo "On system:" $namer
echo "From the directory:" $startdir
echo " --------------------------------------"
echo ""

# Output found files in a list that Excel would appreciate
echo "Filename|Filesize (bytes)|Modified"

</pre>

Here it is being used in Cygwin on windows

[<img loading="lazy" class="alignnone size-medium wp-image-538" title="listfiles" src="http://northredoubt.com/n/wp-content/uploads/2012/06/listfiles-300x128.gif" alt="" width="300" height="128" srcset="http://northredoubt.com/n/wp-content/uploads/2012/06/listfiles-300x128.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/06/listfiles-500x214.gif 500w, http://northredoubt.com/n/wp-content/uploads/2012/06/listfiles.gif 887w" sizes="(max-width: 300px) 100vw, 300px" />][1]

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/06/listfiles.gif