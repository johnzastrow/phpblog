---
title: Of file sizes and nearest neighbors
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite
  - Uncategorized

---
_This post is part of a series <a title="Example with PHP and Spatialite, part 1" href="http://northredoubt.com/n/2012/01/16/example-with-php-and-spatialite-part-1/" target="_blank">[1]</a>, <a title="Example with PHP and Spatialite, part 2" href="http://northredoubt.com/n/2012/01/17/example-with-php-and-spatialite-part-2/" target="_blank">[2]</a>, <a title="Spatialite and Spatial Indexes" href="http://northredoubt.com/n/2012/01/18/spatialite-and-spatial-indexes/" target="_blank">[3]</a>, <a title="Spatialite Speed Test" href="http://northredoubt.com/n/2012/01/20/spatialite-speed-test/" target="_blank">[4],</a> <a title="Of file sizes and nearest neighbors" href="http://northredoubt.com/n/2012/01/27/of-file-sizes-and-nearest-neighbors/" target="_blank">[5]</a>_

I’m continuing my exploration of Spatialite and decided to try the classic problem of identifying the nearest feature to a selected feature. This is commonly known as a nearest neighbor question and Regina and Leo at Boston GIS cover the issues quite well in their posts <a href="http://www.bostongis.com/PrinterFriendly.aspx?content_name=postgis_nearest_neighbor" target="_blank">here</a>, <a href="http://www.bostongis.com/PrinterFriendly.aspx?content_name=postgis_nearest_neighbor_generic" target="_blank">here</a>, and <a href="http://www.bostongis.com/blog/index.php?/categories/7-nearest-neighbor" target="_blank">here</a>.

But, of course each computer system is a little different and generic solutions that work on many systems are rarely the most efficient. In spatial databases, how one uses indexes is a common difference and Spatialite doesn’t implement spatial indexes in the same was as say PostGIS. Therefore, the approach for accessing the indexes through SQL statements also differs.

So, I’ll keep running with my classic point that I’ve been using in this series. The new question is:

<span style="color: #008000;"><strong><em> “What is the nearest “place feature” (another point) to the point location at -70.25 E, 43.802 N?”</em></strong></span>

As with my HUC12 question, I want to try to make Spatialite slow by asking a simple question against a lot of data. I want to push its boundaries or determine that its performance is essentially always within the “excellent” range when faced with any reasonable amount of data.


<figure id="attachment_370" aria-describedby="caption-attachment-370" style="width: 316px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-370" title="Lots of dots" alt="Lots of dots" src="http://northredoubt.com/n/wp-content/uploads/2012/01/22millionfeatures.png" width="316" height="98" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/22millionfeatures.png 316w, http://northredoubt.com/n/wp-content/uploads/2012/01/22millionfeatures-300x93.png 300w" sizes="(max-width: 316px) 100vw, 316px" />][1]<figcaption id="caption-attachment-370" class="wp-caption-text">Lots of dots</figcaption></figure>

**  
** 

<figure id="attachment_377" aria-describedby="caption-attachment-377" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-377" title="All the dots" alt="All the dots" src="http://northredoubt.com/n/wp-content/uploads/2012/01/zoomout-300x127.png" width="300" height="127" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/zoomout-300x127.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/zoomout-500x212.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/zoomout.png 824w" sizes="(max-width: 300px) 100vw, 300px" />][2]<figcaption id="caption-attachment-377" class="wp-caption-text">All the dots</figcaption></figure>

<strong style="color: #333333; font-style: normal; line-height: 24px;">and here is the dot density for New York City area.</strong>

<figure id="attachment_376" aria-describedby="caption-attachment-376" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-376" title="Recognize this shape?" alt="Recognize this shape?" src="http://northredoubt.com/n/wp-content/uploads/2012/01/ny-300x166.png" width="300" height="166" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/ny-300x166.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/ny-1024x568.png 1024w, http://northredoubt.com/n/wp-content/uploads/2012/01/ny-500x277.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/ny.png 1199w" sizes="(max-width: 300px) 100vw, 300px" />][3]<figcaption id="caption-attachment-376" class="wp-caption-text">Recognize this shape?</figcaption></figure>

Which leads me to a <span style="text-decoration: underline;"><digression></span>

These GNIS data are available as a pipe-delimited text file. But The first few characters in the first row (right before the first column name, or maybe it’s some kind of magic binary header) are always screwed up.. which confounds some software that starts with Arc… .

<figure id="attachment_367" aria-describedby="caption-attachment-367" style="width: 267px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-367" title="The offending characters in the GNIS text files" alt="The offending characters in the GNIS text files" src="http://northredoubt.com/n/wp-content/uploads/2012/01/offending_char.png" width="267" height="76" />][4]<figcaption id="caption-attachment-367" class="wp-caption-text">The offending characters in the GNIS text files</figcaption></figure>

So, I always end up having to bring the data through Microsoft Access to cleanse them.. then back out again usually as a comma-delimited, double-quoted text file (CSV). In this case, I ran that “fixed” text file through ArcCatalog to make a Shapefile that I could import into Spatialite.. because I seem to like to torture myself. Of course, halfway through the import Spatialite informed me that it couldn’t proceed because one of the geometries was corrupted. Throwing my hands up, I switched to using Spatialite’s heavenly text import routine to import the pipe-delimited file into a table.

&nbsp;

Then I simply ran these commands from a tutorial at Spatialite’s site:

<pre class="lang:default decode:true">SELECT AddGeometryColumn('XYGNIS', 'Geometry',  4326, 'POINT', 'XY', 0);</pre>

&nbsp;

Where the value explanations are :


&nbsp;

Voila. This created the needed structures in the database to hold the indexes, setup needed triggers, etc. Then I created the point geometry with a recipe like the following:

<pre class="lang:sql decode:1 " >UPDATE XYGNIS SET Geometry = MakePoint(PRIM_LONG_DEC, PRIM_LAT_DEC,4326);</pre>

Lastly, I had to tell Spatialite to build the spatial indexes. I just did this through the GUI by right-clicking on my new Geometry field.


<figure id="attachment_366" aria-describedby="caption-attachment-366" style="width: 873px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-366" title="Geo Files Sizes" alt="Geo Files Sizes" src="http://northredoubt.com/n/wp-content/uploads/2012/01/file_sizes.png" width="873" height="490" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/file_sizes.png 873w, http://northredoubt.com/n/wp-content/uploads/2012/01/file_sizes-300x168.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/file_sizes-500x280.png 500w" sizes="(max-width: 873px) 100vw, 873px" />][5]<figcaption id="caption-attachment-366" class="wp-caption-text">Geo Files Sizes</figcaption></figure>

<span style="text-decoration: underline;"> </digression></span>

&nbsp;

But now back to my question. Here is the performance without using my indexes.

<pre class="lang:sql decode:1 " >SELECT feature_name, feature_class, ST_Distance(Geometry,
MakePoint(-70.250, 43.802)) AS Distance
FROM XYGNIS
WHERE distance &lt; 0.1
ORDER BY distance LIMIT 1</pre>

<figure id="attachment_378" aria-describedby="caption-attachment-378" style="width: 528px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-378" title="No indexes, nearest point feature within 0.1 degrees" alt="No indexes, nearest point feature within 0.1 degrees" src="http://northredoubt.com/n/wp-content/uploads/2012/01/no-index_pt.png" width="528" height="208" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/no-index_pt.png 528w, http://northredoubt.com/n/wp-content/uploads/2012/01/no-index_pt-300x118.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/no-index_pt-500x196.png 500w" sizes="(max-width: 528px) 100vw, 528px" />][6]<figcaption id="caption-attachment-378" class="wp-caption-text">No indexes, nearest point feature within 0.1 degrees</figcaption></figure>

&nbsp;

**44.5 seconds.** Not as bad one would think. I’m using a radius of 0.1 degrees to limit how many results I get back. I played around with this value and you should too. To find the very nearest feature, I LIMIT the number of my results to 1, and because I’ve sorted, or ordered my results ascending by distance, I can get a single answer that is the very nearest feature.

&nbsp;

I still want my queries to finish in less than a second, so with a little help from an email response from Sandro, here is the same query against 2.2 million points that **finishes in 0.036 seconds**. Barely enough time to open the database connection I think.

<pre class="lang:sql decode:1 " >SELECT feature_name, feature_class, ST_Distance(Geometry,
MakePoint(-70.250, 43.802)) AS Distance
FROM XYGNIS
WHERE distance &lt; 0.1
AND ROWID IN (
SELECT ROWID FROM SpatialIndex
WHERE f_table_name = 'XYGNIS'
AND search_frame =
BuildCircleMbr(-70.250, 43.802, 0.1))
ORDER BY distance LIMIT 10</pre>

<figure id="attachment_368" aria-describedby="caption-attachment-368" style="width: 509px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-368" title="Still fast enough" alt="Still fast enough" src="http://northredoubt.com/n/wp-content/uploads/2012/01/even_faster.png" width="509" height="275" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/even_faster.png 509w, http://northredoubt.com/n/wp-content/uploads/2012/01/even_faster-300x162.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/even_faster-500x270.png 500w" sizes="(max-width: 509px) 100vw, 509px" />][7]<figcaption id="caption-attachment-368" class="wp-caption-text">Still fast enough</figcaption></figure>

Pretty cool. BTW, if I wanted more than one result, I can just change the LIMIT to a higher number, like 10.

<figure id="attachment_369" aria-describedby="caption-attachment-369" style="width: 752px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-369" title="When 1 isn't enough" alt="When 1 isn't enough" src="http://northredoubt.com/n/wp-content/uploads/2012/01/nearest10.png" width="752" height="461" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/nearest10.png 752w, http://northredoubt.com/n/wp-content/uploads/2012/01/nearest10-300x183.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/nearest10-489x300.png 489w" sizes="(max-width: 752px) 100vw, 752px" />][8]<figcaption id="caption-attachment-369" class="wp-caption-text">When 1 isn&#8217;t enough</figcaption></figure>

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/01/22millionfeatures.png
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/01/zoomout.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/01/ny.png
 [4]: http://northredoubt.com/n/wp-content/uploads/2012/01/offending_char.png
 [5]: http://northredoubt.com/n/wp-content/uploads/2012/01/file_sizes.png
 [6]: http://northredoubt.com/n/wp-content/uploads/2012/01/no-index_pt.png
 [7]: http://northredoubt.com/n/wp-content/uploads/2012/01/even_faster.png
 [8]: http://northredoubt.com/n/wp-content/uploads/2012/01/nearest10.png