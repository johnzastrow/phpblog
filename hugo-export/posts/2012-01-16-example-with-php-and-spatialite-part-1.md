---
title: Example with PHP and Spatialite, part 1
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

So, PHP supports SQLite out of the box (<a href="http://www.sqlite.org/" target="_blank">http://www.sqlite.org/</a>, now at 3.7.10), making it a nice combo if you want to do some reads from your page. My impression is that SQLite is not recommended if you want stuff with database writes and you have more than a couple visitors. But reading seems to be fine.

I think this fits my use cases just fine as I just want to hang out some very basic utility services that can run on the &#8220;single beige box in the corner&#8221; or the &#8220;beige cloud in the sky&#8221; with few resources needed. First, I want to create a simple REST service that, when passed a pair of long/lat coordinates, will do nothing but return that name of the county they are in. Then I&#8217;ll do one for watershed identifiers (<a href="http://www.nrcs.usda.gov/wps/portal/nrcs/main/national/ngmc" target="_blank">USDA WBD HUC12</a> to be exact), and eventually maybe I&#8217;ll work up to a nearest place service (<a href="http://www.geonames.org/" target="_blank">http://www.geonames.org/</a>) and so on. Maybe even some downstream/upstream routing with Spatialite&#8217;s network utilities <a href="http://www.gaia-gis.it/spatialite-2.3.1/spatialite-network-2.3.1.html" target="_blank" class="broken_link">[1]</a>, <a href="http://www.gaia-gis.it/gaia-sins/Using-Routing.pdf" target="_blank">[2]</a>, <a href="http://www.gaia-gis.it/spatialite-2.4.0-4/spatialite-cookbook/html/dijkstra.html" target="_blank" class="broken_link">[3]</a>.


So, I began compiling spatialite, and at the time I was using 3.0beta1a, so I just kept running with it. I&#8217;m still learning the basics of spatialite so I dinked around a bit. Then I followed the instructions for getting spatialite running within PHP  <a href="http://www.gaia-gis.it/spatialite-2.4.0-4/spatialite-cookbook/html/php.html" target="_blank" class="broken_link">[here]</a> and/or <a href="http://www.gaia-gis.it/spatialite-2.4.0-4/splite-php.html" target="_blank" class="broken_link">[here]</a> (not sure which one is the official guide. The site has been migrating to a new infrastructure lately).

After making way too many typos, I got it working and am getting the expected output. I also added some timer code which tells me that from my Ubuntu VM running on my 6-month-old laptop I&#8217;m completing these ~30,000 operations in about 6 seconds against the in-memory database, including opening and closing the connection to a database and tables that are created each page load.

<figure id="attachment_284" aria-describedby="caption-attachment-284" style="width: 300px" class="wp-caption alignnone">[<img loading="lazy" class="size-medium wp-image-284" title="Sample spatialite with PHP screen" src="http://northredoubt.com/n/wp-content/uploads/2012/01/Screenshot-at-2012-01-16-094923-300x157.png" alt="Sample spatialite with PHP screen" width="300" height="157" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/Screenshot-at-2012-01-16-094923-300x157.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/Screenshot-at-2012-01-16-094923-500x261.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/01/Screenshot-at-2012-01-16-094923.png 731w" sizes="(max-width: 300px) 100vw, 300px" />][1]<figcaption id="caption-attachment-284" class="wp-caption-text">Sample spatialite with PHP screen</figcaption></figure>

My next exercise will be to figure out how to connect to an existing disk-based DB and try some simpler operations. My goal will be to get my operations out the door in about 1 second on modest hardware under no load.

__  
<!--more-->

[cc lang=&#8217;php&#8217; ]

Testing SpatiaLite on PHP

# Testing SpatiaLite on PHP

<!--?php //  Start TIMER //  ----------- $stimer = explode( ' ', microtime() ); $stimer = $stimer[1] + $stimer[0]; //  ----------- # connecting some SQLite DB # we'll actually use an IN-MEMORY DB # so to avoid any further complexity; # an IN-MEMORY DB simply is a temp-DB $db = new SQLite3(':memory:'); # loading SpatiaLite as an extension $db--->loadExtension(&#8216;libspatialite.so&#8217;);

\# enabling Spatial Metadata  
\# using v.2.4.0 this automatically initializes SPATIAL\_REF\_SYS  
\# and GEOMETRY_COLUMNS  
$db->exec(&#8220;SELECT InitSpatialMetadata()&#8221;);

\# reporting some version info  
$rs = $db->query(&#8216;SELECT sqlite_version()&#8217;);  
while ($row = $rs->fetchArray())  
{  
print &#8221;

### SQLite version: $row[0]

&#8220;;  
}  
$rs = $db->query(&#8216;SELECT spatialite_version()&#8217;);  
while ($row = $rs->fetchArray())  
{  
print &#8221;

### SpatiaLite version: $row[0]

&#8220;;  
}

\# creating a POINT table  
$sql = &#8220;CREATE TABLE test_pt (&#8220;;  
$sql .= &#8220;id INTEGER NOT NULL PRIMARY KEY,&#8221;;  
$sql .= &#8220;name TEXT NOT NULL)&#8221;;  
$db->exec($sql);  
\# creating a POINT Geometry column  
$sql = &#8220;SELECT AddGeometryColumn(&#8216;test_pt&#8217;, &#8220;;  
$sql .= &#8220;&#8216;geom&#8217;, 4326, &#8216;POINT&#8217;, &#8216;XY&#8217;)&#8221;;  
$db->exec($sql);

\# creating a LINESTRING table  
$sql = &#8220;CREATE TABLE test_ln (&#8220;;  
$sql .= &#8220;id INTEGER NOT NULL PRIMARY KEY,&#8221;;  
$sql .= &#8220;name TEXT NOT NULL)&#8221;;  
$db->exec($sql);  
\# creating a LINESTRING Geometry column  
$sql = &#8220;SELECT AddGeometryColumn(&#8216;test_ln&#8217;, &#8220;;  
$sql .= &#8220;&#8216;geom&#8217;, 4326, &#8216;LINESTRING&#8217;, &#8216;XY&#8217;)&#8221;;  
$db->exec($sql);

\# creating a POLYGON table  
$sql = &#8220;CREATE TABLE test_pg (&#8220;;  
$sql .= &#8220;id INTEGER NOT NULL PRIMARY KEY,&#8221;;  
$sql .= &#8220;name TEXT NOT NULL)&#8221;;  
$db->exec($sql);  
\# creating a POLYGON Geometry column  
$sql = &#8220;SELECT AddGeometryColumn(&#8216;test_pg&#8217;, &#8220;;  
$sql .= &#8220;&#8216;geom&#8217;, 4326, &#8216;POLYGON&#8217;, &#8216;XY&#8217;)&#8221;;  
$db->exec($sql);

\# inserting some POINTs  
\# please note well: SQLite is ACID and Transactional  
\# so (to get best performance) the whole insert cycle  
\# will be handled as a single TRANSACTION  
$db->exec(&#8220;BEGIN&#8221;);  
for ($i = 0; $i < 10000; $i++) { # for POINTs we&#8217;ll use full text sql statements $sql = &#8220;INSERT INTO test_pt (id, name, geom) VALUES (&#8220;; $sql .= $i + 1; $sql .= &#8220;, &#8216;test POINT #&#8221;; $sql .= $i + 1; $sql .= &#8220;&#8216;, GeomFromText(&#8216;POINT(&#8220;; $sql .= $i / 1000.0; $sql .= &#8221; &#8220;; $sql .= $i / 1000.0; $sql .= &#8220;)&#8217;, 4326))&#8221;; $db->exec($sql);  
}  
$db->exec(&#8220;COMMIT&#8221;);

\# checking POINTs  
$sql = &#8220;SELECT DISTINCT Count(*), ST_GeometryType(geom), &#8220;;  
$sql .= &#8220;ST\_Srid(geom) FROM test\_pt&#8221;;  
$rs = $db->query($sql);  
while ($row = $rs->fetchArray())  
{  
\# read the result set  
$msg = &#8220;Inserted &#8220;;  
$msg .= $row[0];  
$msg .= $row[1];  
$msg .= &#8221; SRID=&#8221;;  
$msg .= $row[2];  
print &#8221;

### $msg

&#8220;;  
}

\# inserting some LINESTRINGs  
\# this time we&#8217;ll use a Prepared Statement  
$sql = &#8220;INSERT INTO test_ln (id, name, geom) &#8220;;  
$sql .= &#8220;VALUES (?, ?, GeomFromText(?, 4326))&#8221;;  
$stmt = $db->prepare($sql);  
$db->exec(&#8220;BEGIN&#8221;);  
for ($i = 0; $i < 10000; $i++) { # setting up values / binding $name = &#8220;test LINESTRING #&#8221;; $name .= $i + 1; $geom = &#8220;LINESTRING(&#8220;; if (($i%2) == 1) { # odd row: five points $geom .= &#8220;-180.0 -90.0, &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8220;, 180.0 90.0&#8243;; } else { # even row: two points $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= 10.0 + ($i / 1000.0); } $geom .= &#8220;)&#8221;; $stmt->reset();  
$stmt->clear();  
$stmt->bindValue(1, $i+1, SQLITE3_INTEGER);  
$stmt->bindValue(2, $name, SQLITE3_TEXT);  
$stmt->bindValue(3, $geom, SQLITE3_TEXT);  
$stmt->execute();  
}  
$db->exec(&#8220;COMMIT&#8221;);

\# checking LINESTRINGs  
$sql = &#8220;SELECT DISTINCT Count(*), ST_GeometryType(geom), &#8220;;  
$sql .= &#8220;ST\_Srid(geom) FROM test\_ln&#8221;;  
$rs = $db->query($sql);  
while ($row = $rs->fetchArray())  
{  
\# read the result set  
$msg = &#8220;Inserted &#8220;;  
$msg .= $row[0];  
$msg .= $row[1];  
$msg .= &#8221; SRID=&#8221;;  
$msg .= $row[2];  
print &#8221;

### $msg

&#8220;;  
}

\# insering some POLYGONs  
\# this time too we&#8217;ll use a Prepared Statement  
$sql = &#8220;INSERT INTO test_pg (id, name, geom) &#8220;;  
$sql .= &#8220;VALUES (?, ?, GeomFromText(?, 4326))&#8221;;  
$stmt = $db->prepare($sql);  
$db->exec(&#8220;BEGIN&#8221;);  
for ($i = 0; $i < 10000; $i++) { # setting up values / binding $name = &#8220;test POLYGON #&#8221;; $name .= $i + 1; $geom = &#8220;POLYGON((&#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= 10.0 + ($i / 1000.0); $geom .= &#8220;, &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8221; &#8220;; $geom .= -10.0 &#8211; ($i / 1000.0); $geom .= &#8220;))&#8221;; $stmt->reset();  
$stmt->clear();  
$stmt->bindValue(1, $i+1, SQLITE3_INTEGER);  
$stmt->bindValue(2, $name, SQLITE3_TEXT);  
$stmt->bindValue(3, $geom, SQLITE3_TEXT);  
$stmt->execute();  
}  
$db->exec(&#8220;COMMIT&#8221;);

\# checking POLYGONs  
$sql = &#8220;SELECT DISTINCT Count(*), ST_GeometryType(geom), &#8220;;  
$sql .= &#8220;ST\_Srid(geom) FROM test\_pg&#8221;;  
$rs = $db->query($sql);  
while ($row = $rs->fetchArray())  
{  
\# read the result set  
$msg = &#8220;Inserted &#8220;;  
$msg .= $row[0];  
$msg .= $row[1];  
$msg .= &#8221; SRID=&#8221;;  
$msg .= $row[2];  
print &#8221;

### $msg

&#8220;;  
}

\# closing the DB connection  
$db->close();

// End TIMER  
// &#8212;&#8212;&#8212;  
$etimer = explode( &#8216; &#8216;, microtime() );  
$etimer = $etimer[1] + $etimer[0];  
echo &#8216;

<p style="margin: auto; text-align: center;">
  &#8216;;<br /> printf( &#8220;Script timer: <strong>%f</strong> seconds.&#8221;, ($etimer-$stimer) );<br /> echo &#8216;
</p>

&#8216;;  
// &#8212;&#8212;&#8212;

?>

&nbsp;

[/cc]

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=b905b2d7-4e01-8480-af63-6bb7ac2588a0" alt="" />
</div>

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/01/Screenshot-at-2012-01-16-094923.png