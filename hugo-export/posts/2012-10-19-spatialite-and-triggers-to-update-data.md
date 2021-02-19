---
title: Spatialite and Triggers to Update Data
author: John C. Zastrow
type: post
date: 2012-10-19T05:08:08+00:00
url: /2012/10/19/spatialite-and-triggers-to-update-data/
categories:
  - Data processing
  - Database
  - GIS
  - Spatialite
  - Uncategorized

---
I finally decided to do a little demo here of a common feature I need on a lot of projects. We often have systems that maintain point locations of things (create, update, delete, view them) and having attributes of spatial relationship automatically applied to them is often quite handy. For example, in a system that tracks illegal dumping observations, knowing the county that dots of the sightings falls into (because the counties regulate dumping) would be handy thing to know immediately for reporting and filtering. We used to ask users to know what county their point (e.g., position of trash sighting) was in. But it&#8217;s a lot nicer (and perhaps more accurate) to do some simple spatial magic for the user.

I spend time worrying about water quality so in this example I want to what small watershed (12-digit hydrologic unit code or HUC 12&#8217;s) my Points of Interest (POIs) fall into. I also want to know what date and time the record was created or updated on. Consider the following basic map. Blue polygons are HUC12s and the stars are my POIs – both stored in the same sqlite/spatialite file (a single .db or .sqlite file).

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

<figure id="attachment_628" aria-describedby="caption-attachment-628" style="width: 300px" class="wp-caption alignnone"><a href="http://northredoubt.com/n/2012/10/19/spatialite-and-triggers-to-update-data/editing_4trigger/" rel="attachment wp-att-628"><img loading="lazy" class="size-medium wp-image-628" alt="No need to fill in the attributes that will be set by the trigger" src="http://northredoubt.com/n/wp-content/uploads/2012/10/editing_4trigger-300x221.png" width="300" height="221" srcset="http://northredoubt.com/n/wp-content/uploads/2012/10/editing_4trigger-300x221.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/10/editing_4trigger-406x300.png 406w, http://northredoubt.com/n/wp-content/uploads/2012/10/editing_4trigger.png 586w" sizes="(max-width: 300px) 100vw, 300px" /></a><figcaption id="caption-attachment-628" class="wp-caption-text">No need to fill in the attributes that will be set by the trigger</figcaption></figure>

Here&#8217;s a quick screen to show how to start and end an editing session in Qgis. You must Save your edits to commit them and fire the trigger.

<figure style="width: 586px" class="wp-caption alignnone"><img loading="lazy" alt="" src="http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea5.png" width="586" height="355" /><figcaption class="wp-caption-text">Don&#8217;t forget to SAVE your edits, or the triggers won&#8217;t fire.</figcaption></figure>

<figure id="attachment_627" aria-describedby="caption-attachment-627" style="width: 300px" class="wp-caption alignnone"><a style="font-style: normal; line-height: 24px; text-decoration: underline;" href="http://northredoubt.com/n/2012/10/19/spatialite-and-triggers-to-update-data/saved_edits_trigger/" rel="attachment wp-att-627"><img loading="lazy" class="size-medium wp-image-627" style="border-color: #bbbbbb; background-color: #eeeeee;" alt="saved_edits_trigger" src="http://northredoubt.com/n/wp-content/uploads/2012/10/saved_edits_trigger-300x169.png" width="300" height="169" srcset="http://northredoubt.com/n/wp-content/uploads/2012/10/saved_edits_trigger-300x169.png 300w, http://northredoubt.com/n/wp-content/uploads/2012/10/saved_edits_trigger-500x282.png 500w, http://northredoubt.com/n/wp-content/uploads/2012/10/saved_edits_trigger.png 649w" sizes="(max-width: 300px) 100vw, 300px" /></a><figcaption id="caption-attachment-627" class="wp-caption-text">Voila. The triggered attributes were updated.</figcaption></figure>

&nbsp;

&nbsp;

 [1]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea1.png
 [2]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea2.png
 [3]: http://northredoubt.com/n/wp-content/uploads/2012/10/101912_0507_Spatialitea3.png