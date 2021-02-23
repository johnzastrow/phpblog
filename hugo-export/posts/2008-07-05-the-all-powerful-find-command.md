---
 #  The all powerful find command
categories:
  - Linux

---
find <starting point> <search criteria> <action>

The starting point is the name of the directory where find should start  
looking for files. The find command examines all files in this  
directory (and any subdirectories) to see if they meet the specified  
search criteria. If any do, find performs the specified action on each  
found file. Here are some of the most useful search criteria options:

-name pattern Find files with names that match the pattern.  
-size [+|-] n Find files larger or smaller than a certain size.  

And here are the actions that can be applied to found files:

-print Print just the names of matching files.  
-exec command Execute a command with the file name as input.  
-ok command Same as -exec, but asks for confirmation first.

That all might look a bit confusing, so here are some examples to bring  
things down to earth. To find files (starting in the current directory)  
with names ending with .data and to print their names, try this:

find . -name &#8216;*.data&#8217; -print  
company.data  
donor.data  
grades.data  
sorted.data  
words.data

To find files larger than 40K and print the file names and details (use  
a minus sign instead of a plus sign to find files smaller than a  
certain size), issue this command:

find . -size +40k -ls

To find all files modified within the last 5 days:

find / -mtime -5 -print

The &#8211; in front of the 5 modifies the meaning of the time as &#8220;less than five days.&#8221; The command

find / -mtime +5 -print

To find all files with zero length and ask if they should be deleted:

find / -size 0 -ok rm {} ;