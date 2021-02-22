---
title: Postgis data loader from shapefile bash shell script
categories:
  - GIS

---
Run this script in a directory of shp files to create STDOUT that will load them all into postgis

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;  
#!/bin/sh  
\# jcz aug 24, 2005  
\# clip off the &#8220;.shp&#8221; file extensions before use  
\# drops existing shapes if they are the same name

for z in \`ls *.shp  
do  
echo &#8220;shp2pgsql $z $z > $z.sql&#8221;  
echo &#8220;psql -d -f $z.sql&#8221;  
done