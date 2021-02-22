---
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite
  - Uncategorized

---


![][1] 

Note that I have an unique, incrementing primary key column (PKUID), then NAME and TYPE columns. We don&#8217;t see it, but there is also a Geometry column to store the coordinates of my points.

&nbsp;

Now I&#8217;ll add two columns to store the HUC12 and DATE and TIME of the edits to the points.

<pre class="lang:sql decode:1 " >ALTER TABLE "mypois" ADD COLUMN HUC_12 TEXT;
ALTER TABLE "mypois" ADD COLUMN UPDATE_DT DATETIME; </pre>

Here is the full structure now.

<pre class="lang:sql decode:1 " >CREATE TABLE "mypois"(
pkuid integer primary key autoincrement,

"NAME" text,
"TYPE" text,
"geometry" POINT,
UPDATE_DT DATETIME,
HUC_12 TEXT)
</pre>

Now my attribute table looks like this.

![][2] 

OK. So I&#8217;ve got a place to store these attributes. Now let&#8217;s apply the database triggers. We&#8217;ll create to add the data during an INSERT operation, and another for an UPDATE. Note that triggers must be uniquely named in a Sqlite database. So, I&#8217;ve prefixed my triggers with the table name.

![][3] 

&nbsp;

And here&#8217;s the code.

<pre class="lang:sql decode:1 " >CREATE TRIGGER mypois_UPD_UDT_HUC12 AFTER UPDATE ON mypois
BEGIN
UPDATE mypois SET UPDATE_DT = DATETIME ('NOW')
WHERE rowid = new.rowid ;
UPDATE mypois SET HUC_12 =
(
SELECT cumberland_huc12.HUC_12
FROM cumberland_huc12, mypois
WHERE ST_Intersects (
mypois.geometry, cumberland_huc12.Geometry)
AND mypois.ROWID = NEW.ROWID
)
WHERE mypois.ROWID = NEW.ROWID;
END

</pre>

and

<pre class="lang:sql decode:1 " >CREATE TRIGGER mypois_INS_UDT_HUC12 AFTER INSERT ON mypois
BEGIN
UPDATE mypois SET UPDATE_DT = DATETIME ('NOW')
WHERE rowid = new.rowid ;
UPDATE mypois SET HUC_12 =
(
SELECT cumberland_huc12.HUC_12
FROM cumberland_huc12, mypois
WHERE ST_Intersects (
mypois.geometry, cumberland_huc12.Geometry)
AND mypois.ROWID = NEW.ROWID
)
WHERE mypois.ROWID = NEW.ROWID;
END

</pre>

&nbsp;

Now let me use Qgis to enter a new point. The screen below is just filling in the non-calculated attributes.

&nbsp;


Here&#8217;s a quick screen to show how to start and end an editing session in Qgis. You must Save your edits to commit them and fire the trigger.

<figure style="width: 586px" class="wp-caption alignnone"><img loading="lazy" alt="" src="http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea5.png" width="586" height="355" /><figcaption class="wp-caption-text">Don&#8217;t forget to SAVE your edits, or the triggers won&#8217;t fire.</figcaption></figure>


&nbsp;

&nbsp;

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea1.png
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea2.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea3.png