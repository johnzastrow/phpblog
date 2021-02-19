---
title: exif from pictures for GIS
author: John C. Zastrow
type: post
date: 2012-04-19T13:38:47+00:00
url: /2012/04/19/exif-from-pictures-for-gis/
categories:
  - Data processing
  - Database
  - GIS

---
I&#8217;m going to do a little Open Street Mapping of my area &#8211; focusing on the many parks and landtrust areas around. So I&#8217;ve been thinking about options to document locations and such. Of course I have a rockin HTC EVO 4G with on-board GPS. So, I&#8217;m thinking that in addition to logging coordinates with my <a href="https://play.google.com/store/apps/details?id=com.mendhak.gpslogger&hl=en" target="_blank" class="broken_link">GPSLogger</a> app I&#8217;m going to try to use my phone and the on-board GPS to grab locations through photos as a rapid way to input and ground truth stuff. Once I end up with a directory full of images, I want a handy script or utility to batch extract all of the coordinates from the embedded EXIF info in the image header.

Enter the <del>utility amazing</del> swiss army tool **exiftool (**<http://www.sno.phy.queensu.ca/~phil/exiftool/>) Its capabilities are too long to cover here. But suffice it to say, this one tool does pretty much everything I need. Here&#8217;s what I&#8217;m doing.

Imagine the command as follows:

<pre>exiftool -csv -c "%+.8f" SourceFile -CameraID -CreateDate -CreationTime -DateAcquired -DateTimeOriginal -Directory -ExifByteOrder -ExifImageHeight -ExifImageWidth -FileName -FileSize -GPSAltitude -GPSAltitudeRef -GPSDateStamp -GPSDateTime -GPSLatitude -GPSLatitudeRef -GPSLongitude -GPSLongitudeRef -GPSMapDatum -GPSPosition -GPSProcessingMethod -GPSSatellites -GPSTimeStamp -GPSVersionID -ImageHeight -ImageSize -ImageUniqueID -ImageWidth -Make -Model -Subject -XPKeywords -r Pictures &gt; ~/myphotorecords.csv</pre>

where:

**-c &#8220;%.8f&#8221;** = change coordinate format to decimal degrees with 8 places of precision  
**-TAGNAME** = write out values for this EXIF tag  
**-csv** = output all tags in tabular CSV format suitable for working in Excel or QGIS  
**-r** = recurse through all DIRECTORIES named next  
**>** = output to this .csv file.  
**~** = my home directory in. In this case I&#8217;m running on Windows 7 with Cygwin. So the actual file path to find the file from Windows is c:\cygwin\home\jcz  
**myphotorecords.csv** = the output file

below is the example of a run using the above command

[<img loading="lazy" class="alignnone size-medium wp-image-440" title="cygwin_exiftool" src="http://northredoubt.com/n/wp-content/uploads/2012/04/cygwin_exiftool-300x84.gif" alt="" width="300" height="84" srcset="http://northredoubt.com/n/wp-content/uploads/2012/04/cygwin_exiftool-300x84.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/04/cygwin_exiftool-500x140.gif 500w, http://northredoubt.com/n/wp-content/uploads/2012/04/cygwin_exiftool.gif 584w" sizes="(max-width: 300px) 100vw, 300px" />][1]

below is example output with some fields clipped

[<img loading="lazy" class="alignnone size-medium wp-image-441" title="example_exiftool_output" src="http://northredoubt.com/n/wp-content/uploads/2012/04/example_exiftool_output-300x4.gif" alt="" width="300" height="4" srcset="http://northredoubt.com/n/wp-content/uploads/2012/04/example_exiftool_output-300x4.gif 300w, http://northredoubt.com/n/wp-content/uploads/2012/04/example_exiftool_output-1024x15.gif 1024w, http://northredoubt.com/n/wp-content/uploads/2012/04/example_exiftool_output-500x7.gif 500w" sizes="(max-width: 300px) 100vw, 300px" />][2]  
This should import nicely into my GIS of choice where I will QC the data. Then I&#8217;ll proceed to my favorite Open Street Map edit and start submitting.

&nbsp;

PS. the GPSlogger tool saves tracks as KML and GPX, in addition to somehow also directly submitting to Open Street Map with tags&#8230; something I&#8217;ll have to play around with.

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/04/cygwin_exiftool.gif
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/04/example_exiftool_output.gif