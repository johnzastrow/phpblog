---
title: Spatialite Speed Test
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite

---
_This post is part of a series <a title="Example with PHP and Spatialite, part 1" href="http://northredoubt.com/n/2012/01/16/example-with-php-and-spatialite-part-1/" target="_blank">[1]</a>, <a title="Example with PHP and Spatialite, part 2" href="http://northredoubt.com/n/2012/01/17/example-with-php-and-spatialite-part-2/" target="_blank">[2]</a>, <a title="Spatialite and Spatial Indexes" href="http://northredoubt.com/n/2012/01/18/spatialite-and-spatial-indexes/" target="_blank">[3]</a>, <a title="Spatialite Speed Test" href="http://northredoubt.com/n/2012/01/20/spatialite-speed-test/" target="_blank">[4],</a> <a title="Of file sizes and nearest neighbors" href="http://northredoubt.com/n/2012/01/27/of-file-sizes-and-nearest-neighbors/" target="_blank">[5]</a><a title="Spatialite Speed Test" href="http://northredoubt.com/n/2012/01/20/spatialite-speed-test/" target="_blank"><br /> </a>_

Based on my earlier tests I felt confident that I could expand the size of the dataset to my intended extent. So I grabbed 12-digit HUCS for the entire United States. I was confident this would crush spatialite and finally make the response time for my question extend to close to 1 second. But just in case it didn&#8217;t, I would make my question harder at the same time.

> While I&#8217;m playing with these queries I need a reference guide. Of course the starting point is the spatialite SQL guide found here <a style="font-style: normal; line-height: 24px; text-decoration: underline;" href="http://www.gaia-gis.it/gaia-sins/spatialite-sql-3.0.0.html" target="_blank" class="broken_link">http://www.gaia-gis.it/gaia-sins/spatialite-sql-3.0.0.html</a>. But, while this is a nice list of functions, I need more help than it provides. Thankfully, spatialite shares many technical concepts with PostGIS (follows OGC, etc. SQL and data standards, and they both use the GEOS spatial library). So, I&#8217;ve been successfully poaching help from the PostGIS documentation (<a href="http://www.postgis.org/docs/ST_GeomFromText.html" target="_blank">http://www.postgis.org/docs/ST_GeomFromText.html</a>) &#8230; which is quite good and gives plenty of use examples.

So, getting back to the data, here is my new queryable data set.

<figure id="attachment_341" aria-describedby="caption-attachment-341" style="width: 609px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-341" title="12-digit hydrologic units for the entire US" alt="12-digit hydrologic units for the entire US" src="http://northredoubt.com/n/wp-content/uploads/2012/01/whole_country.png" width="609" height="225" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/whole_country.png 609w, http://northredoubt.com/n/wp-content/uploads/2012/01/whole_country-300x110.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/whole_country-500x184.png 500w" sizes="(max-width: 609px) 100vw, 609px" />][1]<figcaption id="caption-attachment-341" class="wp-caption-text">12-digit hydrologic units for the entire US</figcaption></figure>

The pink blob on the right my new, harder question.. searching with not one pair of coordinates, but a bunch of pairs in the form of a pink polygon. Pink scares computers, so this should hurt it a little. It might also be scary that my database file representing the HUCs is now **1.9GB** in size (lots of coordinates and the indexes to describes them).

<figure id="attachment_343" aria-describedby="caption-attachment-343" style="width: 772px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-343" title="Pink test polygon" alt="Pink test polygon" src="http://northredoubt.com/n/wp-content/uploads/2012/01/example_poly.png" width="772" height="534" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/example_poly.png 772w, http://northredoubt.com/n/wp-content/uploads/2012/01/example_poly-300x207.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/example_poly-433x300.png 433w" sizes="(max-width: 772px) 100vw, 772px" />][2]<figcaption id="caption-attachment-343" class="wp-caption-text">Pink test polygon</figcaption></figure>

Because I&#8217;m likely going to be using coordinate pairs passed in from some kind of Web application, I converted the polygon to well-known text using

&nbsp;

<pre class="lang:pgsql decode:true">SELECT ST_AsText(geom) from test_polys;</pre>

&nbsp;

&nbsp;

which of course gives us

<figure id="attachment_351" aria-describedby="caption-attachment-351" style="width: 628px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-351" title="select a geometry (polygon) as well-known text (wkt)" alt="" src="http://northredoubt.com/n/wp-content/uploads/2012/01/selectwkt.png" width="628" height="173" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/selectwkt.png 628w, http://northredoubt.com/n/wp-content/uploads/2012/01/selectwkt-300x82.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/selectwkt-500x137.png 500w" sizes="(max-width: 628px) 100vw, 628px" />][3]<figcaption id="caption-attachment-351" class="wp-caption-text">select a geometry (polygon) as well-known text (wkt)</figcaption></figure>

With the handy text string to describe my polygon given to me, I&#8217;m able to just copy and paste it into my text SQL. So let&#8217;s do that and the first query should really hurt because I&#8217;m not going to use an index. Note that I switched from Contains.. to Intersects since I want to detect anything that touches my pink poly.

&nbsp;

<pre class="lang:default decode:true">select HU_12_NAME FROM huc12
WHERE ST_Intersects(Geometry, ST_GeomFromText('POLYGON((-70.286127 43.839038, 
-70.305482 43.823696, -70.30855 43.798912, -70.292028 43.773421, 
-70.243169 43.769644, -70.231367 43.774601, -70.193601 43.811186, 
-70.186048 43.836206, -70.264648 43.839274, -70.264648 43.839274, 
-70.274089 43.840218, -70.286127 43.839038))')) = 1</pre>

&nbsp;

How did it do? Surprisingly well. 40 seconds give or take. Of course, that won&#8217;t work for my application, so I&#8217;m keeping my fingers crossed that the index rescues me.

<figure id="attachment_344" aria-describedby="caption-attachment-344" style="width: 470px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-344" title="Polygon query with no index" alt="Polygon query with no index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/poly_no_index.png" width="470" height="343" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/poly_no_index.png 470w, http://northredoubt.com/n/wp-content/uploads/2012/01/poly_no_index-300x218.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/poly_no_index-411x300.png 411w" sizes="(max-width: 470px) 100vw, 470px" />][4]<figcaption id="caption-attachment-344" class="wp-caption-text">Polygon query with no index</figcaption></figure>

Now how about with the index? Here&#8217;s the query.

<pre class="lang:default decode:true crayon-selected">select HU_12_NAME FROM huc12
WHERE ST_Intersects(Geometry, ST_GeomFromText('POLYGON((-70.286127 43.839038, 
-70.305482 43.823696, -70.30855 43.798912, -70.292028 43.773421, 
-70.243169 43.769644, -70.231367 43.774601, -70.193601 43.811186, 
-70.186048 43.836206, -70.264648 43.839274, -70.264648 43.839274, 
-70.274089 43.840218, -70.286127 43.839038))')) = 1
AND ROWID IN (
SELECT ROWID
FROM SpatialIndex
WHERE f_table_name = 'huc12'
AND search_frame = ST_GeomFromText('POLYGON((-70.286127 43.839038, 
-70.305482 43.823696, -70.30855 43.798912, -70.292028 43.773421, 
-70.243169 43.769644, -70.231367 43.774601, -70.193601 43.811186, 
-70.186048 43.836206, -70.264648 43.839274, -70.264648 43.839274, 
-70.274089 43.840218, -70.286127 43.839038))'));</pre>

&nbsp;

And survey says! **0.186 seconds!** Oh yeah.

<figure id="attachment_342" aria-describedby="caption-attachment-342" style="width: 504px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-342" title="Pink polygon query with spatial index" alt="Pink polygon query with spatial index" src="http://northredoubt.com/n/wp-content/uploads/2012/01/poly_with_index.png" width="504" height="311" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/poly_with_index.png 504w, http://northredoubt.com/n/wp-content/uploads/2012/01/poly_with_index-300x185.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/poly_with_index-486x300.png 486w" sizes="(max-width: 504px) 100vw, 504px" />][5]<figcaption id="caption-attachment-342" class="wp-caption-text">Pink polygon query with spatial index</figcaption></figure>

So this all well and good, but the real reason why these queries are so fast is because the test geometry (the pink polygon) is so small. So lets push that a little.

<figure id="attachment_353" aria-describedby="caption-attachment-353" style="width: 620px" class="wp-caption alignnone">[<img loading="lazy" class="size-full wp-image-353" title="Multipart polygon with lotsa geometry" alt="Multipart polygon with lotsa geometry" src="http://northredoubt.com/n/wp-content/uploads/2012/01/lotsa_geometry.png" width="620" height="424" srcset="http://northredoubt.com/n/wp-content/uploads/2012/01/lotsa_geometry.png 620w, http://northredoubt.com/n/wp-content/uploads/2012/01/lotsa_geometry-300x205.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/01/lotsa_geometry-438x300.png 438w" sizes="(max-width: 620px) 100vw, 620px" />][6]<figcaption id="caption-attachment-353" class="wp-caption-text">Multipart polygon with lotsa geometry</figcaption></figure>

So, here I&#8217;ve made a single multipart polygon with lots of vertices to keep my query simple. I&#8217;ll spare you the geometry and the query, but the pink polygon above, querying a whole country of HUC12s with the spatial index, took **1.4 seconds**. So, we finally broke our time limit with enough testing geometry.

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/01/whole_country.png
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/01/example_poly.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/01/selectwkt.png
 [4]: http://northredoubt.com/n/wp-content/uploads/2012/01/poly_no_index.png
 [5]: http://northredoubt.com/n/wp-content/uploads/2012/01/poly_with_index.png
 [6]: http://northredoubt.com/n/wp-content/uploads/2012/01/lotsa_geometry.png