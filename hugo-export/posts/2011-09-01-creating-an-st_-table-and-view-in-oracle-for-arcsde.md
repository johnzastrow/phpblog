---
title: Creating an ST_ table and view in Oracle for ArcSDE
categories:
  - Data processing
  - Database
  - GIS

---
I created a table with ST_GEOMETRY as a column with SQL, inserted records, created a view with some filtering and registered both with ArcSDE.

They are both accessible and useable from ArcMap and ArcCatalog.

Steps:  
create and load the table

 [cc lang=&#8217;sql&#8217; ]  
CREATE TABLE TEST\_GIS\_PERMITS (OID integer NOT NULL, permit\_no nvarchar2(12), location sde.st\_geometry);

CREATE INDEX IX1\_TGP ON TEST\_GIS\_PERMITS (LOCATION) INDEXTYPE IS SDE.ST\_SPATIAL\_INDEX PARAMETERS(&#8216;ST\_GRIDS = 4644.5262325165 ST\_SRID = 8 ST\_COMMIT_ROWS = 10000  PCTFREE 0 INITRANS 4&#8242;) NOPARALLEL;

CREATE UNIQUE INDEX UX1\_TGP ON TEST\_GIS_PERMITS (OID) NOLOGGING NOPARALLEL;

INSERT INTO TEST\_GIS\_PERMITS (OID, permit\_no, location) (SELECT objectid, permit\_no, shape FROM SW\_PERMITS\_09_2007);

commit;  
[/cc]

then create the view

[cc lang=&#8217;sql&#8217; ]

CREATE VIEW V\_TEST\_GIS_PERMITS

AS

SELECT oid, permit_no, location

FROM TEST\_GIS\_PERMITS

WHERE SUBSTR(permit_no,1,3) = &#8216;A90&#8242;;

    [/cc]

register the layer with SDE

[cc lang=&#8217;bash&#8217; ]

C:\Users\myname>sdelayer -o register -l TEST\_GIS\_PERMITS,LOCATION -t ST\_GEOMETRY -C OID,USER -u GA\_DEV -p devGA0628 -s DIVS135GEODEV -i sde:oracle11g:/:GA_DEV -e p -R 1

ArcSDE 10.0  for Oracle11g Build 685 Fri May 14 12:05:43  2010  
Layer    Administration Utility  
&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;

Successfully Created Layer.

[/cc]

&nbsp;

 Register the view with SDE

[cc lang=&#8217;bash&#8217; ]

C:\Users\myname>sdelayer -o register -l V\_TEST\_GIS\_PERMITS,LOCATION -t ST\_GEOMETRY -C OID,USER -u GA\_DEV -p devGA0628 -s DIVS135GEODEV -i sde:oracle11g:/:GA\_DEV -e p -R 1

ArcSDE 10.0  for Oracle11g Build 685 Fri May 14 12:05:43  2010

Layer    Administration Utility

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;

<span>Successfully Created Layer.</p> 

<p>
  [/cc]
</p>

<p>
</p>