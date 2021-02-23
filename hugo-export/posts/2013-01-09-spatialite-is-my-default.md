---
 #  Spatialite is my default
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite
  - Uncategorized

---

<a href="http://northredoubt.com/n/2013/01/09/spatialite-is-my-default/spatialite_files/" rel="attachment wp-att-605"><img loading="lazy" class="alignnone size-medium wp-image-605" alt="spatialite_files" src="http://northredoubt.com/n/wp-content/uploads/2012/12/spatialite_files-300x263.png" width="300" height="263" srcset="http://northredoubt.com/n/wp-content/uploads/2012/12/spatialite_files-300x263.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/12/spatialite_files-341x300.png 341w, http://northredoubt.com/n/wp-content/uploads/2012/12/spatialite_files.png 610w" sizes="(max-width: 300px) 100vw, 300px" /></a>

I like <a href="http://slashgeo.org/2010/09/15/FOSS4G-2010-Notes-SpatiaLite-Shapefile-Future" target="_blank" class="broken_link">spatialite</a>, or at least what it provides, because like Qgis, it attempts to be an elegant mix of capabilities that focus on what I need most of the time. It also addresses some of the shortcomings of its primary competitor, Shapefiles. In fact, other <a title="http://slashgeo.org/2012/12/21/OGC-Draft-GeoPackage-Specification-Finally-Shapefile-Format-Replacement" href="http://slashgeo.org/2012/12/21/OGC-Draft-GeoPackage-Specification-Finally-Shapefile-Format-Replacement" target="_blank" class="broken_link">people</a> involved with the <a href="http://spatiallyadjusted.com/2012/12/20/ogc-draft-geopackage-specification/" target="_blank" class="broken_link">OGC</a> like it too for the same reasons. In this post I&#8217;m going to jot down some of my thoughts on the strengths that Spatialite brings to the table. Then in my next post I&#8217;ll record some of the weaknesses or areas for improvement &#8211; perhaps in comparison to ESRI Shapefiles and their modern replacement &#8211; <a href="http://resources.arcgis.com/content/geodatabases/10.0/file-gdb-api" target="_blank">ESRI File Geodatabases</a>.

Specifically, I like the following capabilities and aspects of the software:

  * **Cross-platform** &#8211; Libraries and files for *NIX and Win, along with Win binaries kindly provided. The Windows stuff are always available at the main site, while eventually binaries get released in the usual Ubuntu repos (not sure about RPMs).
  * **Reuse** &#8211; it stands on the shoulders of other very successful projects and only reinvents the wheels needed for lighter weight implementations than say exist in PostGIS.

<figure id="attachment_603" aria-describedby="caption-attachment-603" style="width: 300px" class="wp-caption alignnone"><a href="http://northredoubt.com/n/2013/01/09/spatialite-is-my-default/qgis_project_file/" rel="attachment wp-att-603"><img loading="lazy" class="size-medium wp-image-603" alt="Simple Qgis project file loading a Spatialite layer" src="http://northredoubt.com/n/wp-content/uploads/2012/12/qgis_project_file-300x243.png" width="300" height="243" srcset="http://northredoubt.com/n/wp-content/uploads/2012/12/qgis_project_file-300x243.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/12/qgis_project_file-370x300.png 370w, http://northredoubt.com/n/wp-content/uploads/2012/12/qgis_project_file.png 938w" sizes="(max-width: 300px) 100vw, 300px" /></a><figcaption id="caption-attachment-603" class="wp-caption-text">Simple Qgis project file (XML) loading a Spatialite layer</figcaption></figure>

  * **It’s Just a Database** – Unlike file geodbs that kinda act/smell like databases, sqlite/spatialite IS a database. It is a simple cousin to the real RDBMS and follows the same standards. So, you can actually use complex and complete SQL constructs for example instead just basic SELECTs.

  * **It’s Not a Database Server** – If I want to run a full spatially-enabled server and feed and water it – I would and do run Postgres/PostGIS. But with Spatialite, the data are just files and the software that connects to them is where the magic happens. Simple.

  * **Large Amounts of Data** – Though limited by the fact that a Spatialite database is a single file on the file system, we can still store AND use many 10’s of GB of data in them. And that’s plenty for me, especially since if I need more, or I need to support a lot of connections I’m going to run a server anyhow. I don&#8217;t need fast, multiple connections in my file-based data store.
  * **Capable** &#8211; There are fewer and fewer things that I want to do in any spatial database that I can&#8217;t do in Spatialite &#8211; take a look the huge function list <a href="http://www.gaia-gis.it/gaia-sins/spatialite-sql-4.0.0.html" target="_blank" class="broken_link">http://www.gaia-gis.it/gaia-sins/spatialite-sql-4.0.0.html</a> . Calculate &#8220;a grid of triangular cells (having the edge length of _size_) precisely covering the input Geometry&#8221; right in the database? As the Gecko says, &#8220;No problem.&#8221; In fact, if anything I wish Sandro would stop adding spatial functions and capabilities and add a little more glue to the project.. but that&#8217;s my next post.
  * **Fast** &#8211; Yep, Spatialite is snappy just like Sqlite. You will find some benchmarks in the wild, including on this site. Spatialite is plenty fast and just <a href="https://www.gaia-gis.it/fossil/libspatialite/wiki?name=speed-optimization" target="_blank">keeps getting faster</a>.
  * **Common** &#8211; Well not quite yet. But others folks are slowly getting interested in and supporting it as the project matures. <a href="http://docs.safe.com/fme/reader_writerPDF/spatialitefdo.pdf" target="_blank" class="broken_link">FME </a>finally got there.
  * **Moving** &#8211; Spatialite development is progressing, despite really only being actively developed by Sandro and Brad (<a href="https://www.gaia-gis.it/fossil/libspatialite/timeline" target="_blank">it appears</a>). I&#8217;ll say more about development in my wishlist post, but at this point I&#8217;m just glad that the project is active.

I&#8217;ve probably missed listing some things, but you get the idea. Simply stated, there is a lot for me to like.  I think we&#8217;ll continue to hear more about Spatialite in the future as the simple and easy (easy ALWAYS wins) solutions continue to overtake the complex ones&#8230; so stay tuned!

<span style="text-decoration: underline;"><em>References and random links:</em></span>

&nbsp;

  * <a href="https://www.gaia-gis.it/fossil/libspatialite/wiki?name=switching-to-4.0" target="_blank">http://www.frogmouth.net/blog/?cat=3</a>
  * <a href="https://www.gaia-gis.it/fossil/libspatialite/wiki?name=switching-to-4.0" target="_blank">http://northredoubt.com/n/?s=spatialite&submit=Search</a>

  * <a href="https://www.gaia-gis.it/fossil/libspatialite/wiki?name=switching-to-4.0" target="_blank">https://www.gaia-gis.it/fossil/libspatialite/wiki?name=switching-to-4.0</a>

&nbsp;

&nbsp;

 [1]: http://spatiallyadjusted.com/2012/12/18/the-kml-problem/