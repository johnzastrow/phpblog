---
title: 'Simple grep and search & replace'
author: John C. Zastrow
type: post
date: 2008-07-06T01:36:36+00:00
url: /2008/07/05/simple-grep-and-search-replace/
categories:
  - Linux

---
grep -Hn -e &#8221; int&#8221; \*.c\* *.h

searches for the string &#8220;int&#8221; files ending in .c* or .h in the the current directory directory 

Returns:

! P8.CPP:52: cerr << &#8220;cannot allocate int *p1&#8221; << endl ;  
! P8.CPP:59: } //format => int *p = new int[100];  
! P9.CPP:9:inline int sumup( int x, int y)  
! P9.CPP:17: int i1 = 10, i2 = 20, sum = 0;  
! functions.h:3:int doTotal(int x1, int x2)  
! functions.h:12:float doAverage(int x1, int x2)  
! functions.h:19:int doDifference(int x1, int x2)

In case you want to search through some text files in a series of  
directories replacing one set of text for another in each of the files,  
try this shell script.

#!/bin/sh  
for file in \`grep -liR &#8220;someword&#8221; ./*\`;  
do  
sed &#8216;s/someword/someother_word/g&#8217; $file > tmp/$$ && mv tmp/$$ $file  
done