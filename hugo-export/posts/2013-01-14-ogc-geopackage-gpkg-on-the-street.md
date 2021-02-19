---
title: 'OGC Geopackage [GPKG] on the street'
author: John C. Zastrow
type: post
date: 2013-01-14T16:42:16+00:00
url: /2013/01/14/ogc-geopackage-gpkg-on-the-street/
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite

---
I am thrilled to see the OGC Geopackage [GPKG] spec hit the street and see Sandro, Brad and Spatialite taking such a prominent role there. Using <a href="http://www.gaia-gis.it/gaia-sins/" target="_blank">Spatialite</a> as the vector reference implementation makes a lot of sense. The spec does seem a little bloated to me. But OTOH, sometimes I would want all that stuff – and creating a standard to support them means that they will be there for me if I need them. Now maybe we can get Spatialite better supported out in the world… Tiles, rasters, metadata, improved SRS support, plus all the normal vector data I normally get all in an easy-to-use relational, SQL-compliant database  &#8211; yippee! What&#8217;s next? Watershed delineation on my phone?!

Here’s the link to the announcement on the Spatialite list, and I’ll include Sandro’s announcement below.

<https://groups.google.com/forum/#!msg/spatialite-users/XPYzxnYMCrU/i5lxfnShTNUJ>

<p style="padding-left: 60px;">
  <strong>sandro furieri <a.furieri@lqt.it> Sat, Jan 12, 2013 at 5:59 AM</strong><br /> <strong>To: spatialite-users@googlegroups.com</strong>
</p>

<p style="padding-left: 60px;">
  Hi List,<br /> I&#8217;m glad to announce you all that SpatiaLite is going to be adopted as the reference implementation by the candidate OGC GeoPackage (GPKG) standard. [1]
</p>

<p style="padding-left: 60px;">
  The current draft of the candidate GPKG standard is now available for download; comments are welcome. [2]<br /> [1] http://www.opengeospatial.org/standards/requests/95<br /> [2] https://portal.opengeospatial.org/files/?artifact_id=51391
</p>

<p style="padding-left: 60px;">
  <span style="text-decoration: underline;">Very short abstract for busy readers:</span>
</p>

<p style="padding-left: 60px;">
  A GeoPackage is an open, non-proprietary, platform-independent container for distribution of all kinds of geospatial data. It&#8217;s a self-describing single file ready for immediate use<br /> supporting mapping and other geospatial applications. The primary purpose of GPKG is supporting Mobile device users who operate in disconnected or limited network connectivity.
</p>

<p style="padding-left: 120px;">
  But GPKG is a standard exchange format as well, supporting data distribution, collection of observations, and distribution of change-only updates.
</p>

<p style="padding-left: 60px;">
  <strong>Gossips:</strong><br /> During the last months both Brad and I were members of the OGC Committee producing the candidate standard, and we contributed to its definition.
</p>

<p style="padding-left: 60px;">
  The next release of SpatiaLite 4.1.0 will (optionally) include a brand new GeoPackage extension developed by Brad.
</p>

<p style="padding-left: 60px;">
  bye Sandro
</p>

<span style="text-decoration: underline;"><strong>Here are some other references:</strong></span>

  * <http://foss4g-na.org/schedule/army-geospatial-center-geopackage-gpkg/>
  * <http://www.opengeospatial.org/projects/groups/geopackageswg>
  * <http://www.opengeospatial.org/node/1756>
  * <http://spatiallyadjusted.com/2013/01/10/geopackage-comment-period-is-open/>{.broken_link}
  * <http://blog.geomusings.com/2013/01/09/comment-period-open-for-geopackage-specification-draft/>
  * <http://www.weogeo.com/blog/The_GeoPackage.html>{.broken_link}
  * <a href="http://osgeo-org.1560.n6.nabble.com/FYI-New-OGC-Standards-Activity-Candidate-GeoPackage-Standard-td5013223.htmlhttp://" target="_blank" class="broken_link">http://osgeo-org.1560.n6.nabble.com/FYI-New-OGC-Standards-Activity-Candidate-GeoPackage-Standard-td5013223.html</a>
  * <a href="https://groups.google.com/forum/#!msg/geospatial-mobile-data-format-for-tiles/jEsh6tfTXkE/Nxl96snB_MMJ" target="_blank">https://groups.google.com/forum/#!msg/geospatial-mobile-data-format-for-tiles/jEsh6tfTXkE/Nxl96snB_MMJ</a>
  * <a href="https://twitter.com/search?q=%23geopackage" target="_blank">https://twitter.com/search?q=%23geopackage</a>
  * <a href="http://lists.osgeo.org/pipermail/standards/2012-October/000535.html" target="_blank">http://lists.osgeo.org/pipermail/standards/2012-October/000535.html</a>
  * <a href="http://northredoubt.com/n/?s=spatialite&submit=Searchhttp://" target="_blank">http://northredoubt.com/n/?s=spatialite&submit=Search</a>

&nbsp;