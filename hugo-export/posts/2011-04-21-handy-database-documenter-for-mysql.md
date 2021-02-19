---
title: Handy database documenter for MySQL
author: John C. Zastrow
type: post
date: 2011-04-21T19:39:45+00:00
url: /2011/04/21/handy-database-documenter-for-mysql/
categories:
  - Database

---
UPDATE: see the next iteration on this project <a title="Handy database documenter/profiler for mysql, cont." href="http://northredoubt.com/n/2011/07/18/handy-database-documenterprofiler-for-mysql-cont/" target="_blank">[here]</a>

&nbsp;

Here&#8217;s a view that will spit out just about everything MySQL (5.1) knows about the tables and fields it maintains for you. The first field can be joined to the output of something like

<pre>SELECT * FROM AZ_CA_NV_UT_species_LOCAL PROCEDURE ANALYSE(10000, 4000);</pre>

to see before and after &#8220;optimal&#8221; <a href="http://www.mysqlperformanceblog.com/2009/03/23/procedure-analyse/" target="_blank">(1)</a>   <a href="http://dave-stokes.blogspot.com/2008/02/procedure-analyse.html" target="_blank">(2)</a> field types and lengths predicted by the internal <span style="text-decoration: underline;"><strong>PROCEDURE ANALYSE.</strong></span>

<pre>CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_field_table_data` AS
SELECT
CONCAT_WS('.',`tables`.`TABLE_SCHEMA`,`columns`.`TABLE_NAME`,`columns`.`COLUMN_NAME`) AS `FIELD_NAME`,
`tables`.`TABLE_COMMENT`             AS `TABLE_COMMENT`,
`columns`.`TABLE_NAME`               AS `TABLE_NAME`,
`columns`.`COLUMN_NAME`              AS `COLUMN_NAME`,
`columns`.`COLUMN_TYPE`              AS `COLUMN_TYPE`,
`columns`.`DATA_TYPE`                AS `DATA_TYPE`,
`columns`.`COLUMN_KEY`               AS `COLUMN_KEY`,
`tables`.`TABLE_SCHEMA`              AS `TABLE_SCHEMA`,
`tables`.`TABLE_TYPE`                AS `TABLE_TYPE`,
`tables`.`ENGINE`                    AS `ENGINE`,
`tables`.`VERSION`                   AS `VERSION`,
`tables`.`ROW_FORMAT`                AS `ROW_FORMAT`,
`tables`.`TABLE_ROWS`                AS `TABLE_ROWS`,
`tables`.`AVG_ROW_LENGTH`            AS `AVG_ROW_LENGTH`,
`tables`.`DATA_LENGTH`               AS `DATA_LENGTH`,
`tables`.`MAX_DATA_LENGTH`           AS `MAX_DATA_LENGTH`,
`tables`.`INDEX_LENGTH`              AS `INDEX_LENGTH`,
`tables`.`AUTO_INCREMENT`            AS `AUTO_INCREMENT`,
`tables`.`CREATE_TIME`               AS `CREATE_TIME`,
`tables`.`UPDATE_TIME`               AS `UPDATE_TIME`,
`tables`.`TABLE_COLLATION`           AS `TABLE_COLLATION`,
`tables`.`CHECKSUM`                  AS `CHECKSUM`,
`tables`.`CREATE_OPTIONS`            AS `CREATE_OPTIONS`,
`columns`.`ORDINAL_POSITION`         AS `ORDINAL_POSITION`,
`columns`.`COLUMN_DEFAULT`           AS `COLUMN_DEFAULT`,
`columns`.`IS_NULLABLE`              AS `IS_NULLABLE`,
`columns`.`CHARACTER_MAXIMUM_LENGTH` AS `CHARACTER_MAXIMUM_LENGTH`,
`columns`.`CHARACTER_OCTET_LENGTH`   AS `CHARACTER_OCTET_LENGTH`,
`columns`.`NUMERIC_PRECISION`        AS `NUMERIC_PRECISION`,
`columns`.`NUMERIC_SCALE`            AS `NUMERIC_SCALE`,
`columns`.`CHARACTER_SET_NAME`       AS `CHARACTER_SET_NAME`,
`columns`.`COLLATION_NAME`           AS `COLLATION_NAME`,
`columns`.`EXTRA`                    AS `EXTRA`,
`columns`.`PRIVILEGES`               AS `PRIVILEGES`,
`columns`.`COLUMN_COMMENT`           AS `COLUMN_COMMENT`,
NOW()                                AS `RUN_DATETIME`
FROM (`information_schema`.`tables`
JOIN `information_schema`.`columns`
ON (((`tables`.`TABLE_SCHEMA` = `columns`.`TABLE_SCHEMA`)
AND (`tables`.`TABLE_NAME` = `columns`.`TABLE_NAME`))))</pre>

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=8a34e3ac-a0c2-8733-86c6-ebf35beb73af" alt="" />
</div>