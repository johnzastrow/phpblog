---
title: Dropping columns in sqlite/spatialite
author: John C. Zastrow
type: post
date: 2012-01-28T23:32:00+00:00
url: /2012/01/28/dropping-columns-in-sqlitespatialite-2/
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite

---
<a href="http://www.sqlite.org/faq.html#q11" target="_blank">SQLite doesn&#8217;t have a nice</a> ALTER TABLE DROP COLUMN command and neither does spatialite. Instead, you get to run a long sequence of commands like this. Here I wanted to drop all the extra columns from my huc12 layer for the country.

So, starting with a table that looks like this

<pre class=&#8221;lang:pgsql decode:true&#8221;>

CREATE TABLE &#8220;huc12&#8221; (  
PK_UID INTEGER PRIMARY KEY AUTOINCREMENT,  
&#8220;OBJECTID&#8221; INTEGER,  
&#8220;HUC_8&#8221; TEXT,  
&#8220;HUC_10&#8221; TEXT,  
&#8220;HUC_12&#8221; TEXT,  
&#8220;ACRES&#8221; DOUBLE,  
&#8220;NCONTRB_A&#8221; DOUBLE,  
&#8220;HU\_10\_GNIS&#8221; TEXT,  
&#8220;HU\_12\_GNIS&#8221; TEXT,  
&#8220;HU\_10\_DS&#8221; TEXT,  
&#8220;HU\_10\_NAME&#8221; TEXT,  
&#8220;HU\_10\_MOD&#8221; TEXT,  
&#8220;HU\_10\_TYPE&#8221; TEXT,  
&#8220;HU\_12\_DS&#8221; TEXT,  
&#8220;HU\_12\_NAME&#8221; TEXT,  
&#8220;HU\_12\_MOD&#8221; TEXT,  
&#8220;HU\_12\_TYPE&#8221; TEXT,  
&#8220;META_ID&#8221; TEXT,  
&#8220;STATES&#8221; TEXT,  
&#8220;GlobalID&#8221; TEXT,  
&#8220;SHAPE_Leng&#8221; DOUBLE,  
&#8220;SHAPE_Area&#8221; DOUBLE, &#8220;Geometry&#8221; MULTIPOLYGON)

</pre>

and ending with

<pre class="lang:sql decode:1 " >CREATE TABLE "huc12" (
 PK_UID INTEGER PRIMARY KEY AUTOINCREMENT,
 "HUC_12" TEXT,
 "ACRES" DOUBLE,
 "HU_12_GNIS" TEXT,
 "HU_12_NAME" TEXT,
 "HU_12_MOD" TEXT,
 "HU_12_TYPE" TEXT,
 "GlobalID" TEXT,
 "Geometry" MULTIPOLYGON)</pre>

I ran this stuff in the middle.

<pre class="lang:sql decode:1 " >BEGIN TRANSACTION;
 CREATE temporary TABLE "huc12sm" (
 PK_UID INTEGER PRIMARY KEY AUTOINCREMENT,
 "HUC_12" TEXT,
 "ACRES" DOUBLE,
 "HU_12_GNIS" TEXT,
 "HU_12_NAME" TEXT,
 "HU_12_MOD" TEXT,
 "HU_12_TYPE" TEXT,
 "GlobalID" TEXT,
 "Geometry" MULTIPOLYGON);
 INSERT INTO huc12sm SELECT PK_UID, HUC_12, ACRES, HU_12_GNIS, HU_12_NAME, HU_12_MOD, HU_12_TYPE, GlobalID, Geometry FROM huc12;
 DROP TABLE huc12;
 CREATE TABLE "huc12" (
 PK_UID INTEGER PRIMARY KEY AUTOINCREMENT,
 "HUC_12" TEXT,
 "ACRES" DOUBLE,
 "HU_12_GNIS" TEXT,
 "HU_12_NAME" TEXT,
 "HU_12_MOD" TEXT,
 "HU_12_TYPE" TEXT,
 "GlobalID" TEXT,
 "Geometry" MULTIPOLYGON);
 INSERT INTO huc12 SELECT PK_UID, HUC_12, ACRES, HU_12_GNIS, HU_12_NAME, HU_12_MOD, HU_12_TYPE, GlobalID, Geometry FROM huc12sm;
 DROP TABLE huc12sm;
 COMMIT;
 VACUUM;
 HUC_12, ACRES, HU_12_GNIS, HU_12
 SELECT Count(*), GeometryType("Geometry"), Srid("Geometry"), CoordDimension("Geometry")
 FROM "huc12"
 GROUP BY 2, 3, 4;

SELECT RebuildGeometryTriggers('huc12', 'Geometry')

</pre>

I wish someone would package this stuff into a nice function&#8230; hint hint.