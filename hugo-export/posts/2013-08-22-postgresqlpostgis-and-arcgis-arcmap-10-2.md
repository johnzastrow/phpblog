---
title: PostgreSQL/PostGIS and ArcGIS ArcMap 10.2
author: John C. Zastrow
type: post
date: 2013-08-23T02:56:29+00:00
url: /2013/08/22/postgresqlpostgis-and-arcgis-arcmap-10-2/
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite

---
Of course good things come to those who wait (at least that&#8217;s the wisdom that I pass along to my kids). We expect that after we&#8217;re done waiting we will get something awesome and worth the wait, right? But sometimes what we end up getting is a little underwhelming and as adults we&#8217;re forced to just accept it with a shrug and move on. I feel like that right now and it will become clear why by the end of the post.

But, for now I rejoice in the good part which is that I can finally connect to my handy Postgres/PostGIS database and see my data there using ArcMap. I can query, style and do most other basic things that I have tried. To see how to do this you may want to take a look at the <a href="http://resources.arcgis.com/en/help/main/10.2/index.html#/A_quick_tour_of_geodatabases_in_PostgreSQL/002p000000pt000000/" target="_blank">docs</a>. In this case I installed Postgres 9.2.4 and PostGIS 2.0.something using the EnterpriseDB installer and Stackbuilder (<http://postgis.net/windows_downloads>) . Esri will give you Postgres 9.2.2 which still has that <a href="http://www.postgresql.org/support/security/faq/2013-04-04/" target="_blank">nasty security flaw</a> in it that everyone else upgraded from months ago. 9.2.4 seems to be working fine though using the 9.2.2 client drivers.

Note that Esri keeps the Postgres client drivers away from you unless you are &#8220;authorized&#8221; through your customer number to have these free/Free drivers that are not published by Esri. You must download them separately from the ArcMap install. Here&#8217;s mine [PostgreSQLClientLibs922][1] if you can&#8217;t get access to them cuz you are trying the demo of ArcMap 10.2 &#8211; which makes you not worthy of gaining access to these drivers.

[<img loading="lazy" class="aligncenter size-medium wp-image-753" alt="postgres_drivers" src="http://northredoubt.com/n/wp-content/uploads/2013/08/postgres_drivers-300x163.png" width="300" height="163" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/postgres_drivers-300x163.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/postgres_drivers.png 354w" sizes="(max-width: 300px) 100vw, 300px" />][2]

BTW, if you are a better reader than I you would immediately note that the bit-ness of the drivers should match the \*client\* software that you are installing them into, NOT the database you are connecting to. So, by installing the 64-bit database server, then trying to get ArcMap to use the 64-bit drivers I was doomed to suffer through the useless Esri errors for an hour until I had a face-palm moment. You must give ArcMap the **\*32-bit\*** drivers.

Bug alert: I can&#8217;t reproduce this right now, BUT when I first created the connection ArcMap complained because its default database port for Postgres came up as 54321. If you get an error while first connecting, recall that by default Postgres&#8217;s port is 5432. So you need to force that in the connection &#8220;Instance&#8221; field by entering the machine followed by a comma, then the port number like 127.0.0.1,5432 as shown below.

[<img loading="lazy" class="aligncenter size-medium wp-image-754" alt="db_port" src="http://northredoubt.com/n/wp-content/uploads/2013/08/db_port-300x211.png" width="300" height="211" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/db_port-300x211.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/db_port-425x300.png 425w, http://northredoubt.com/n/wp-content/uploads/2013/08/db_port.png 498w" sizes="(max-width: 300px) 100vw, 300px" />][3]

Once you connect this little issue goes away <shrug>.

So I finally got the DB connection working and was very excited. Here&#8217;s a pic.

[<img loading="lazy" class="aligncenter size-medium wp-image-755" alt="database_data" src="http://northredoubt.com/n/wp-content/uploads/2013/08/database_data-300x201.png" width="300" height="201" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/database_data-300x201.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/database_data-1024x687.png 1024w, http://northredoubt.com/n/wp-content/uploads/2013/08/database_data-446x300.png 446w, http://northredoubt.com/n/wp-content/uploads/2013/08/database_data.png 1042w" sizes="(max-width: 300px) 100vw, 300px" />][4]

You see some poly data from PostGIS (make sure that you set the SRID when loading) and a few points from my handy Spatialite database (no database connection needed to display these Spatialite data. Must be the GDAL/OGR baked right in). Bill Dollins explains a little more about using Spatialite data in ArcMap in this <a href="http://blog.geomusings.com/2013/08/07/spatialite-and-arcgis-10-dot-2/" target="_blank">post.</a>From the docs it seems that Esri is supporting Spatialite 4.0, which may also support the current 4.1 as well.

Here&#8217;s the similar view from QGIS.

[<img loading="lazy" class="aligncenter size-medium wp-image-756" alt="qgis_post" src="http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post-300x191.png" width="300" height="191" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post-300x191.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post-1024x653.png 1024w, http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post-470x300.png 470w, http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post.png 1227w" sizes="(max-width: 300px) 100vw, 300px" />][5]

&nbsp;

Ok, so now I&#8217;m feeling pretty good about myself. How about trying to edit some of these non-geodatabase data in ArcMap? Without too much drama, the short answer seems to be that you can&#8217;t. When Esri says &#8220;you may USE the database data in ArcMap&#8221; they mean you may VIEW it &#8211; and only view it. You may not edit PostGIS data directly in ArcMap.

[<img loading="lazy" class="aligncenter size-medium wp-image-757" alt="no_editing" src="http://northredoubt.com/n/wp-content/uploads/2013/08/no_editing-300x100.png" width="300" height="100" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/no_editing-300x100.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/no_editing-500x166.png 500w, http://northredoubt.com/n/wp-content/uploads/2013/08/no_editing.png 509w" sizes="(max-width: 300px) 100vw, 300px" />][6]

&nbsp;

It&#8217;s not the end of the world since I can do most things in QGIS running side-by-side. But it&#8217;s annoying.

I&#8217;m pretty sure that the Spatialite layer can&#8217;t be edited either. Despite setting all layers displayed to EPSG SRID = 4326 (WGS84) ArcMap still feels that they layers are not in the same coordinate ref. Then goes on to complain about not being able to edit the layer.

<p style="text-align: center;">
  <a href="http://northredoubt.com/n/wp-content/uploads/2013/08/postgis_coordref.png"><img loading="lazy" class="aligncenter size-medium wp-image-758" alt="postgis_coordref" src="http://northredoubt.com/n/wp-content/uploads/2013/08/postgis_coordref-300x213.png" width="300" height="213" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/postgis_coordref-300x213.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/postgis_coordref-421x300.png 421w, http://northredoubt.com/n/wp-content/uploads/2013/08/postgis_coordref.png 504w" sizes="(max-width: 300px) 100vw, 300px" /></a><a href="http://northredoubt.com/n/wp-content/uploads/2013/08/spatiliate_cref.png"><img loading="lazy" class="aligncenter size-medium wp-image-760" alt="spatiliate_cref" src="http://northredoubt.com/n/wp-content/uploads/2013/08/spatiliate_cref-300x230.png" width="300" height="230" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/spatiliate_cref-300x230.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/spatiliate_cref-390x300.png 390w, http://northredoubt.com/n/wp-content/uploads/2013/08/spatiliate_cref.png 511w" sizes="(max-width: 300px) 100vw, 300px" /></a><a href="http://northredoubt.com/n/wp-content/uploads/2013/08/stillnoedit.png"><img loading="lazy" class="aligncenter size-medium wp-image-759" alt="stillnoedit" src="http://northredoubt.com/n/wp-content/uploads/2013/08/stillnoedit-300x78.png" width="300" height="78" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/stillnoedit-300x78.png 300w, http://northredoubt.com/n/wp-content/uploads/2013/08/stillnoedit-500x130.png 500w, http://northredoubt.com/n/wp-content/uploads/2013/08/stillnoedit.png 715w" sizes="(max-width: 300px) 100vw, 300px" /></a>
</p>

So, I&#8217;ve been waiting a long time to be able to use my non-ESRI geodatabase database geodata in ArcMap with all the functions I expect including editing. But I guess I have to wait a bit longer&#8230; sigh..

Here is a picture of the geodata as seen by the free and included Postgres IDE pgAdmin III

[<img loading="lazy" class="aligncenter size-medium wp-image-765" alt="gis_data_indb" src="http://northredoubt.com/n/wp-content/uploads/2013/08/gis_data_indb-268x300.png" width="268" height="300" srcset="http://northredoubt.com/n/wp-content/uploads/2013/08/gis_data_indb-268x300.png 268w, http://northredoubt.com/n/wp-content/uploads/2013/08/gis_data_indb.png 769w" sizes="(max-width: 268px) 100vw, 268px" />][7]

**UPDATE:** I should mention one other thing. I did make some edits to a layer using QGIS and was hoping to see them appear in ArcMap after committing them to the DB. Alas, this did not happen and I had to remove/re-add the layer for the edits to appear. So, it seems that perhaps ArcMap is caching the layer (perhaps in a little hidden FGDB) when it loads.

The recommended approach for editing PostGIS data through off-the-shelf Esriware seems to be through the REST services and a feature service provided by ArcGIS Server 10.2 (since the <a href="http://resources.arcgis.com/en/help/main/10.1/index.html#//01sq00000005000000" target="_blank">Spatial Data Server (SDS)</a> ) is now deprecated and appears to be rolled into Arc Server itself. I do hope that these edits made through Arc Server are immediately available through the online stuff and will not require refreshing any cache.

&nbsp;

**<span style="text-decoration: underline;">Resources:</span>**

  * Of course for simple non-editable basemap needs all you need is a simple tile server sending out pre-rendered pics just like Google does (there are a bunch of options for serving basemaps from <a href="http://www.mapbox.com/developers/mbtiles/" target="_blank">MBTiles</a> using <a href="http://projects.bryanmcbride.com/php-mbtiles-server/leaflet.html" target="_blank" class="broken_link">php </a><a href="http://gis.stackexchange.com/questions/45465/reusing-cached-tiles-with-leaflet-mbtiles-and-mbtiles-php" target="_blank">[1]</a>, python, javascript through <a href="http://fuzzytolerance.info/blog/screencast-26-simple-mbtiles-server-in-node/http://" target="_blank" class="broken_link">nodejs</a>, etc. and the ability to create to create an mbtile file is appearing in more software than just <a href="http://fuzzytolerance.info/blog/automating-tile-generation-with-tilemill/http://" target="_blank" class="broken_link">tilemill, </a><a href="http://fuzzytolerance.info/blog/screencast-11-a-quick-run-through-tilemill/" target="_blank" class="broken_link">[2], </a><a href="http://fuzzytolerance.info/blog/screencast-16-tilemill-part-iii-all-done/" target="_blank" class="broken_link">[3]</a>)  &#8211; <a style="font-style: normal;" href="http://blog.klokantech.com/2013/08/tileserver-wmts-from-map-tiles-and.html" target="_blank">http://blog.klokantech.com/2013/08/tileserver-wmts-from-map-tiles-and.html</a>
  * The ability to read/write geodata in database is dependent on the software being able to understand the format in which the data are stored in the database. Most spatially-enabled DBs use some derivation of the well-known binary (WKB) for storing GEOMETRY or GEOGRAPHY. But each DB interprets that spec a little differently resulting in no two databases actually storing their data in the exact same format. We had an opportunity again recently for at least two projects to use the same format for storing vector geometries as the GeoPackage ALMOST accepted the Spatialite format. But in the end it was rejected.These pages highlight this concept and the issue: 
      * <a href="http://cholmes.wordpress.com/2013/08/20/spatialite-and-geopackage/" target="_blank">http://cholmes.wordpress.com/2013/08/20/spatialite-and-geopackage/</a>
      * <a href="http://www.gaia-gis.it/gaia-sins/BLOB-Geometry.html" target="_blank">http://www.gaia-gis.it/gaia-sins/BLOB-Geometry.html</a>
      * <a href="http://resources.arcgis.com/en/help/main/10.2/index.html#/What_is_the_PostGIS_geometry_type/002p0000006t000000/" target="_blank">http://resources.arcgis.com/en/help/main/10.2/index.html#/What_is_the_PostGIS_geometry_type/002p0000006t000000/</a>

&nbsp;

&nbsp;

 [1]: http://northredoubt.com/n/wp-content/uploads/2013/08/PostgreSQLClientLibs922.zip
 [2]: http://northredoubt.com/n/wp-content/uploads/2013/08/postgres_drivers.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2013/08/db_port.png
 [4]: http://northredoubt.com/n/wp-content/uploads/2013/08/database_data.png
 [5]: http://northredoubt.com/n/wp-content/uploads/2013/08/qgis_post.png
 [6]: http://northredoubt.com/n/wp-content/uploads/2013/08/no_editing.png
 [7]: http://northredoubt.com/n/wp-content/uploads/2013/08/gis_data_indb.png