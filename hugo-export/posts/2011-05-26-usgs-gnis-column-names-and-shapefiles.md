---
title: USGS GNIS column names and shapefiles
categories:
  - Uncategorized

---
If you try to convert the USGS geographic names (GNIS) text files from the website straight into shapefiles, you will have field name collisions because the field names willbe truncated to 10 characters which result in duplicate field names.

Run this script to rename certain fields to avoid this. Note that the entire US results in a file that is over 2 million records. Interestingly, but not surprisingly, the tools that seems to handle this size of data most gracefully is QGIS, not ArcMap. 

#!/bin/sh  
sed -i &#8216;s/DATE\_CREATED/DT\_CREATE/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/DATE\_EDITED/DT\_EDIT/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/FEATURE\_CLASS/FEAT\_CLASS/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/FEATURE\_NAME/FEAT\_NAME/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/PRIM\_LAT\_DEC/YLAT_DEC/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/PRIM\_LONG\_DMS/XLONG_DMS/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/PRIM\_LONG\_DEC/XLONG_DEC/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/PRIMARY\_LAT\_DMS/YLAT_DMS/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/SOURCE\_LAT\_DMS/SRC\_Y\_DMS/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/SOURCE\_LAT\_DEC/SRC\_Y\_DEC/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/SOURCE\_LONG\_DMS/SRC\_X\_DMS/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/SOURCE\_LONG\_DEC/SRC\_X\_DEC/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/STATE\_ALPHA/STATE\_NAME/g&#8217; GNISNationalFile.txt  
sed -i &#8216;s/STATE\_NUMERIC/STATE\_NUM/g&#8217; GNISNationalFile.txt

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=47dfdb49-9584-8cc8-925f-8f5fc3a881a9" />
</div>