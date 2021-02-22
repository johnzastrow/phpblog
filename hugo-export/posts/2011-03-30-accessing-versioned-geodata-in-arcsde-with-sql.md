---
 #  Accessing versioned geodata in ArcSDE with SQL
categories:
  - Database
  - GIS

---
This is excerpted from the following forum post:

&#8220;We&#8217;re running SDE and have several featuresets with versioning turned on&#8230;. We have numerous non-GIS applications that use SQL queries to access information from the spatial data. However, we don&#8217;t get all the features that I&#8217;m expecting to be returned. How do I access the features that have been added/deleted (and are, therefore, &#8220;hidden&#8221; from a straight SQL query)?&#8221;

As long as it is just the attributes that you are after, you can set up a multi-versioned view using sdetable.exe.

**

<pre>sdetable.exe -o create_mv_view -T mvv_wMeter -t wMeter</pre>**

Then on your db connection, you execute the set\_current\_version stored proc to set the version, then issue your select statement on the multi-versioned view:

**

<pre>exec sde.set_current_version 'SDE.SOMEOTHERVERSION'&lt;br /&gt;
GO&lt;br /&gt;
Select COUNT(*) from mvv_wMeter ; </pre>**

> <span style="color: #999999;">i don&#8217;t have it my example, but sdetable.exe needs db connection info arguments: -s,-i,-u,-p,-D in some combination depending on your config (I usually just set the SDEDATABASE,SDEINSTANCE,SDESERVER env vars in a batch file&#8211;sdetable use the env vars if they exist). – Jay Cummins Aug 6 &#8217;10 at 19:39</span>

[I think this ESRI support page may be relevant.][1]

I believe it is worth posting the warnings on that page here:


 <span style="color: #999999;">Never edit the DEFAULT version of the geodatabase using SQL. Starting an edit session on a version obtains an exclusive lock on the state that the version references. If you lock the DEFAULT version, you prevent ArcGIS users from connecting to the geodatabase.</span>

In the 9.3 help page they also warned against editing non-simple feature class attributes (Geometric Networks, Topologies, etc.) via SQL.

 [1]: http://help.arcgis.com/en/arcgisdesktop/10.0/help/index.html#/in_SQL_Server/006z0000001r000000/