---
 #  Example with PHP and Spatialite, part 2
categories:
  - Data processing
  - Database
  - GIS
  - Linux
  - Spatialite
  - Uncategorized
  - Web

---
_This post is part of a series <a title="Example with PHP and Spatialite, part 1" href="http://northredoubt.com/n/2012/01/16/example-with-php-and-spatialite-part-1/" target="_blank">[1]</a>, <a title="Example with PHP and Spatialite, part 2" href="http://northredoubt.com/n/2012/01/17/example-with-php-and-spatialite-part-2/" target="_blank">[2]</a>, <a title="Spatialite and Spatial Indexes" href="http://northredoubt.com/n/2012/01/18/spatialite-and-spatial-indexes/" target="_blank">[3]</a>, <a title="Spatialite Speed Test" href="http://northredoubt.com/n/2012/01/20/spatialite-speed-test/" target="_blank">[4]</a>_

So I&#8217;m ready to take the next steps with my little project. This is a continuation of my [previous post][1] about my little journey. At this point I am connecting to a physical database file that I loaded with some sample data (12-digit watersheds). Now I&#8217;m going to practice with queries and you can see the results below.

Here are the base data.

<figure id="attachment_293" aria-describedby="caption-attachment-293" style="width: 240px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-293" title="12-digit US watersheds (HUC12)" src="http://northredoubt.com/n/wp-content/uploads/2012/01/huc12all-240x300.png" alt="" width="240" height="300" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/huc12all-240x300.png 240w, http://northredoubt.com/n/wp-content/uploads/2012/01/huc12all.png 599w" sizes="(max-width: 240px) 100vw, 240px" />][2]<figcaption id="caption-attachment-293" class="wp-caption-text">12-digit US watersheds (HUC12) and the example data set used here. Found in Southern Maine, Cumberland</figcaption></figure>

And here are some close ups of the data. These are fairly dense polygons.

<figure id="attachment_307" aria-describedby="caption-attachment-307" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-307" title="Example of polygon vertices" src="http://northredoubt.com/n/wp-content/uploads/2012/01/huczoom-300x216.png" alt="Example of polygon vertices" width="300" height="216" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/huczoom-300x216.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/huczoom-415x300.png 415w, http://northredoubt.com/n/wp-content/uploads/2012/01/huczoom.png 870w" sizes="(max-width: 300px) 100vw, 300px" />][3]<figcaption id="caption-attachment-307" class="wp-caption-text">Example of polygon vertices</figcaption></figure>

In fact, it looks like this query is testing the relationship between the point and polygons formed by 144,700 coordinate pairs (vertices) by scanning without the help of an index.

<figure id="attachment_306" aria-describedby="caption-attachment-306" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-306" title="Lots of little points to check" src="http://northredoubt.com/n/wp-content/uploads/2012/01/nodes-300x136.png" alt="Lots of little points to check" width="300" height="136" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/nodes-300x136.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/nodes-500x227.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/nodes.png 665w" sizes="(max-width: 300px) 100vw, 300px" />][4]<figcaption id="caption-attachment-306" class="wp-caption-text">Lots of little points to check</figcaption></figure>

At this point I&#8217;m just going to perform basic queries without using spatial indexes. You will almost always want to use spatial indexes, but I&#8217;m going to practice this in phases so these examples won&#8217;t use indexes.

Note that unlike tradition database indexes, spatial databases like Spatialite and PostGIS (and their GiST/R-tree indexes) do not use indexes for spatial queries unless you explicitly tell them to (though PostGIS seems to use them by default some of the time). You must smartly craft the use of indexes the same way that you do the SQL itself&#8230; or at least it seems this way to me.

In Spatialite, the indexes are just tables and you have to add subqueries to your query to grab the bounding rectangles from the Rtrees to pre-filter your queries for the index-driven speed-up.

And here are the spatial indexes that spatialite sees.

<figure id="attachment_295" aria-describedby="caption-attachment-295" style="width: 147px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-295" title="spatialite_indexes" src="http://northredoubt.com/n/wp-content/uploads/2012/01/spatialite_indexes-147x300.png" alt="spatialite_indexes" width="147" height="300" />][5]<figcaption id="caption-attachment-295" class="wp-caption-text">Spatial indexes used in spatialite</figcaption></figure>

So what&#8217;s in these indexes? Boxes&#8230;as we see below. Hopefully you can imagine how we get boxes from Xmin, Ymin, Xmax, Ymax extents. There is one box for each polygon HUC12 feature (note the PK_UID is the primary key of the main geometry layer). These simple boxes are much simpler to test for spatial relationships that the multitude of vertices we saw above. But also much less accurate; especially for funny shaped things like watersheds. But, we can use these simple boxes to pre-filter the number of features that have to be tested by the more accurate (but lengthy) spatial test &#8211; hence speeding up the overall operation in many cases.

<figure id="attachment_308" aria-describedby="caption-attachment-308" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-308" title="What is in a name... or an Rtree index." src="http://northredoubt.com/n/wp-content/uploads/2012/01/index-300x152.png" alt="What is in a name... or an Rtree index." width="300" height="152" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/index-300x152.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/index-500x253.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/index.png 576w" sizes="(max-width: 300px) 100vw, 300px" />][6]<figcaption id="caption-attachment-308" class="wp-caption-text">What is in a name... or an Rtree index.</figcaption></figure>

&nbsp;

Below is an example of the spatial query used in the code below. Translated, it says, &#8220;show me the name of the HUC12 that contains this point.&#8221;

<figure id="attachment_294" aria-describedby="caption-attachment-294" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-294" title="The free gui provided by spatialite and a spatial query" src="http://northredoubt.com/n/wp-content/uploads/2012/01/spatialgui-300x276.png" alt="The free gui provided by spatialite and a spatial query" width="300" height="276" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/spatialgui-300x276.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/spatialgui-325x300.png 325w, http://northredoubt.com/n/wp-content/uploads/2012/01/spatialgui.png 792w" sizes="(max-width: 300px) 100vw, 300px" />][7]<figcaption id="caption-attachment-294" class="wp-caption-text">The free gui provided by spatialite and a spatial query</figcaption></figure>

Here are the files in the project so far. Of course you&#8217;re not normally going to be putting a  loadable extension library (libspatialite.so) in a web server file directory. But, this is just practice.

<figure id="attachment_299" aria-describedby="caption-attachment-299" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-299" title="Files so far for this project" src="http://northredoubt.com/n/wp-content/uploads/2012/01/files-300x122.png" alt="Files so far for this project" width="300" height="122" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/files-300x122.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/files.png 397w" sizes="(max-width: 300px) 100vw, 300px" />][8]<figcaption id="caption-attachment-299" class="wp-caption-text">Files so far for this project</figcaption></figure>

Here&#8217;s the code of db.php. This isn&#8217;t using spatial indexes, so it&#8217;s scanning 183 features and a whole bunch of vertices to figure out which polygon actually contains that point&#8230; and doing a couple simpler things like opening a connection, asking some simple questions, and closing the connection all in about 0.4 seconds.

[cc lang=&#8217;php&#8217; ]

<html>  
<head>  
<title>Testing SpatiaLite on PHP</title>  
</head>  
<body>  
<h1>Testing SpatiaLite on PHP</h1>

<?php  
// Start TIMER  
// &#8212;&#8212;&#8212;&#8211;  
$stimer = explode( &#8216; &#8216;, microtime() );  
$stimer = $stimer[1] + $stimer[0];  
// &#8212;&#8212;&#8212;&#8211;  
try {  
/\*\\*\* connect to SQLite database \*\**/  
$db = new SQLite3(&#8216;db.sqlite&#8217;);

/\*\\*\* a little message to say we did it \*\**/  
echo &#8216;database connected&#8217;;  
}  
catch(PDOException $e)  
{  
echo $e->getMessage();  
}  
\# loading SpatiaLite as an extension  
$db->loadExtension(&#8216;libspatialite.so&#8217;);

\# reporting some version info  
$rs = $db->query(&#8216;SELECT sqlite_version()&#8217;);  
while ($row = $rs->fetchArray())  
{  
print &#8220;<h3>SQLite version: $row[0]</h3>&#8221;;  
}  
$rs = $db->query(&#8216;SELECT spatialite_version()&#8217;);  
while ($row = $rs->fetchArray())  
{  
print &#8220;<h3>SpatiaLite version: $row[0]</h3>&#8221;;  
}

/* SELECT HU\_12\_NAME FROM huc12 WHERE ST_Contains(Geometry, MakePoint(-70.250,43.802));  
*/  
/*  
* Create a query  
*/  
$sql = &#8220;SELECT DISTINCT Count(*), ST_GeometryType(Geometry), &#8220;;  
$sql .= &#8220;ST_Srid(Geometry) FROM huc12&#8221;;  
$rs = $db->query($sql);  
while ($row = $rs->fetchArray())  
{  
\# read the result set  
$msg = &#8220;There are &#8220;;  
$msg .= $row[0];  
$msg .= $row[1];  
$msg .= &#8221; SRID=&#8221;;  
$msg .= $row[2];  
print &#8220;<h3>$msg</h3>&#8221;;  
}

$sql = &#8220;SELECT HU\_12\_NAME FROM huc12 WHERE ST_Contains(Geometry, MakePoint(-70.250,43.802))&#8221;;  
$rs = $db->query($sql);  
while ($row = $rs->fetchArray())  
{  
\# read the result set  
$msg = &#8220;Your point is in the HUC12: &#8220;;  
$msg .= $row[0];  
print &#8220;<h3>$msg</h3>&#8221;;  
}  
/*  
* do not forget to release all handles !  
*/

\# closing the DB connection  
$db->close();

// End TIMER  
// &#8212;&#8212;&#8212;  
$etimer = explode( &#8216; &#8216;, microtime() );  
$etimer = $etimer[1] + $etimer[0];  
echo &#8216;<p style=&#8221;margin:auto; text-align:center&#8221;>&#8217;;  
printf( &#8220;Script timer: <b>%f</b> seconds.&#8221;, ($etimer-$stimer) );  
echo &#8216;</p>&#8217;;  
// &#8212;&#8212;&#8212;

?>

</body>  
</html>

[/cc]

&nbsp;

Not too bad, but I want this faster because I want to feed it much larger data in my final project.

<figure id="attachment_300" aria-describedby="caption-attachment-300" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-300" title="Results of the first try at this" src="http://northredoubt.com/n/wp-content/uploads/2012/01/testing-300x157.png" alt="Results of the first try at this" width="300" height="157" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/testing-300x157.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/testing-500x261.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/testing.png 617w" sizes="(max-width: 300px) 100vw, 300px" />][9]<figcaption id="caption-attachment-300" class="wp-caption-text">Results of the first try at this</figcaption></figure>

 [1]: http://northredoubt.com/n/2012/01/16/example-with-php-and-spatialite-part-1/ "Example with PHP and Spatialite, part 1"
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/01/huc12all.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/01/huczoom.png
 [4]: http://northredoubt.com/n/wp-content/uploads/2012/01/nodes.png
 [5]: http://northredoubt.com/n/wp-content/uploads/2012/01/spatialite_indexes.png
 [6]: http://northredoubt.com/n/wp-content/uploads/2012/01/index.png
 [7]: http://northredoubt.com/n/wp-content/uploads/2012/01/spatialgui.png
 [8]: http://northredoubt.com/n/wp-content/uploads/2012/01/files.png
 [9]: http://northredoubt.com/n/wp-content/uploads/2012/01/testing.png