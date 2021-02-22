---
title: Recent Spatialite News May 2012
categories:
  - Data processing
  - Database
  - GIS
  - Linux
  - Spatialite

---


**May 24, 2012 &#8211; Recent highlights from the libspatialite source repository at <https://www.gaia-gis.it/fossil/libspatialite/timeline>**

  * Including the latest SQLite 3.7.12.1
  * Including the latest EPSG CRS definitions supported by PROJ4 v.4.8.0
  * Fixing a bug in load\_shapefile() and load\_dbf() double quoting the table name
  * Fix a typo in the configure.ac script that causes problems detecting a 3.3.0 or later version of GEOS.
  * Updating the build scripts in order to support Android (as suggested by Marco Bernasocchi, QGIS-Android)
  * Fixing some GEOS related issues Debian/Ubuntu obsolete GEOS 3.2.2

Sandro (a.furieri ) mentioned on March 7 to the list that libspatialite 3.1.0 was soon to be released. It seems the major focus is to tighten up the code with testing and to introduce a few new features.  Sandro writes in an earlier message,


Sandro also writes in another message, &#8220;Hi List, I&#8217;m glad to announce you all that version 3.1.0 is coming soon :-)” with following edited summary.

**Main goals of 3.1.0:**

  * Test coverage is a major focus. Extensive test coverage: about 95% of code lines are now covered ( something like 1,800 different SQL queries are actually tested)
  * Systematic Valgrind checks: Valgrind is a wonderful tool identifying many   memory-related issues (uninitialized variables, bad pointers, buffer overflows, memory leaks and similar): so we&#8217;ve been able to identify   (and resolve) many potential harmful conditions.
  * Extensive cross-platform testing: thanks to Debian folks, now SpatiaLite  has been built and tested on on an impressively wide range of different   architectures: x86/amd64, ARM, PPC, SPARC, Itanium, IBM S390, and more.  This practically means any possible platform, ranging from the simplest   embedded/mobile since the mightiest mainframe.

Sandro earlier posted a short report on the latest spatialite advancements:

  * The whole test coverage has now been successfully ported on both  MinGW32 and MinGW64  (lcov isn&#8217;t supported on MinGW, but gcov is available anyway, and that&#8217;s enough)
  * The same is for Mac Os X (Leopard) Power PC. This marks a notable step, because this way we were able to identify (and fix) many small portability issues. and testing a big-endian arch (PPC) ensures us that there are no endianness-related issues at all in libspatialite.
  * The next release (v.3.0.2 at the time) will support a more flexible way allowing to initially create and populate the &#8220;spatial\_ref\_sys&#8221; metadata table accordingly to your specific individual requirements (many thanks to Pepijn Van Eeckhoudt; he initially advanced this idea)

**SQL-level:**

=========================================================

<pre class="lang:sql decode:1 " >SELECT InitSpatialMetaData();
</pre>

Same as before, unchanged: the complete EPSG dataset will be inserted into &#8220;spatial\_ref\_sys&#8221; (currently, about 4100+ rows)

<pre class="lang:sql decode:1 " >SELECT InitSpatialMetaData('WGS84');
</pre>

or

<pre class="lang:sql decode:1 " >SELECT InitSpatialMetaData('WGS84_ONLY'); </pre>

only WGS84-related EPSG SRIDs will be inserted into &#8220;spatial\_ref\_sys&#8221; (about 130 rows)

<pre class="lang:sql decode:1 " >SELECT InitSpatialMetaData('NONE'); </pre>

or

<pre class="lang:sql decode:1 " >SELECT InitSpatialMetaData('EMPTY'); </pre>

no EPSG SRID will be inserted into &#8220;spatial\_ref\_sys&#8221; (0 rows)

<pre class="lang:sql decode:1 " ># SELECT InsertEpsgSrid(4326);

</pre>

\*new\* SQL function: will attempt to insert SRID=4326 into &#8220;spatial\_ref\_sys&#8221;. the corresponding EPSG SRID definition will be copied from the inlined dataset internally  defined within the libspatialite library (.DLL, .so, .dylib &#8230;)

**SQL-script sample:**

=========================================================

<pre class="lang:sql decode:1 " >--
-- immediately after connecting a new empty DB

--

SELECT InitSpatialMetaData('NONE');

SELECT InsertEpsgSrid(4326);

SELECT InsertEpsgSrid(3003);

SELECT InsertEpsgSrid(3004);

SELECT InsertEpsgSrid(23032);

SELECT InsertEpsgSrid(23033);

SELECT InsertEpsgSrid(32632);

SELECT InsertEpsgSrid(32633);

SELECT InsertEpsgSrid(25832);

SELECT InsertEpsgSrid(25833);

--

-- done: we've created the "geometry_columns" and "spatial_ref_sys"
-- metadata tables  now "spatial_ref_sys" merely contains 9 rows,
-- corresponding to the SRIDs most frequently used in Italy

</pre>

**C API-level:**

=========================================================

<pre class="lang:c decode:1 " ># SPATIALITE_DECLARE int spatial_ref_sys_init2

#   (sqlite3 * sqlite, int mode, int verbose);

where 'mode' can be one of: GAIA_EPSG_ANY, GAIA_EPSG_WGS84_ONLY

or GAIA_EPSG_NONE

# SPATIALITE_DECLARE int spatial_ref_sys_init

#   (sqlite3 * sqlite, int verbose);

*deprecated* but still supported so not to break back-compatibility;
now simply defaults to:

# init_spatial_ref_sys_init(sqlite, GAIA_EPSG_ANY, verbose);

# SPATIALITE_DECLARE int insert_epsg_srid

#   (sqlite3 * sqlite, int srid);

please see SQL InsertEpsgSrid()
</pre>

> **spatialite CLI and spatialite_gui tools:**  
> No changes at all: these tools will continue to automatically create and fully populate the &#8220;spatial\_ref\_sys&#8221; table when creating a new DB; exactly as before.  Bye Sandro

The overall “spatialite project” includes many ancillary helper programs and code as well. So, on May 5, 2012 Sandro wrote to announce the release of some new and revised helper tools.

&#8220;I&#8217;m pleased to announce you all the following news:

**a) a new library: ReadOSM**  
This library is intended to implement a parser supporting OSM datasets; both input formats OSM-XML and OSM-probuf are equally supported:  
<a href="https://www.gaia-gis.it/fossil/readosm/index" target="_blank">https://www.gaia-gis.it/<wbr>fossil/readosm/index</wbr></a>

**b) A completely revised set of OSM tools (based on ReadOSM) is now included in the latest spatialite-tools v.3.1.0:**  
<a href="https://www.gaia-gis.it/fossil/spatialite-tools/index" target="_blank">https://www.gaia-gis.it/<wbr>fossil/spatialite-tools/index</wbr></a>

**c) a brand new Wiki documentation about OSM tools and OSM networks:**  
<a href="https://www.gaia-gis.it/fossil/spatialite-tools/wiki?name=OSM+tools" target="_blank">https://www.gaia-gis.it/<wbr>fossil/spatialite-tools/wiki?<wbr>name=OSM+tools</wbr></wbr></a>

**Important notices:**

  * building spatialite-tools now absolutely requires ReadOSM  (mandatory dependency)
  * libspatialite v.3.1.0 is \*not\* a prerequisite: you can  successfully build the CLI tools even using the latest v.3.0.1
  * pre-built binary executables for Windows will be released  immediately after releasing libspatialite v3.1.0