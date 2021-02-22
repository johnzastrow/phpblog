---
 #  Upgrade your debian sources.list
categories:
  - Linux

---
apt-spy is a program that benchmarks debian apt-get sources. Run this  
script when you need to find your bets local mirror for grabbing debian  
packages.

#!/bin/sh  
\# jcz 2005-july-13  
#  
\# This script will add the best debian servers to your sources.list file.  
\# You should prune the file by hand when it&#8217;s done.

\# Date and other variables pretty self explanatory, S is seconds  


\# benchmarks 3 north american servers for downloading the testing debian packages  
\# and will overwrite sources.list with the results  
apt-spy -d testing -a north-america -e 3

\# the overwrite makes us copy back our favorites  

echo &#8220;Don&#8217;t forget to prune /etc/apt/sources.list !!!&#8221;