---
title: Handy database documenter/profiler for mysql, cont.
categories:
  - Database

---
Some time ago I wrote down a little <a title="Handy database documenter for MySQL" href="http://northredoubt.com/n/2011/04/21/handy-database-documenter-for-mysql/" target="_blank">script</a> to make a table from the MySQL information schema to describe your database. My eventual goal is to come close to reproducing a poor man&#8217;s database profiling script similar to this crude one ( <a title="Oracle, SQL Server" href="http://www.ipcdesigns.com/data_profiling/" target="_blank">http://www.ipcdesigns.com/data_profiling/</a>), but perhaps less powerful and yet more elegant. I figure it&#8217;s going to take creating some procedures to loop through the chosen tables and columns.

&nbsp;

Towards that end, I figure I need to take the contents of the handy view I made earlier and turn them into a table. Then if I execute some profiling queries, I can create tables from the results and join back to this summary table. So here is me persisting the view created earlier.You can do it this way:

<pre>CREATE TABLE profiler_recs AS SELECT * FROM `v_field_table_data`;
ALTER TABLE `mysql`.`profiler_recs` ADD COLUMN `PROFILE_RECS_ID` BIGINT(20) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY(`PROFILE_RECS_ID`);</pre>

or here is the resulting DDL

<pre>CREATE TABLE `profiler_recs` (
`PROFILE_RECS_ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
`FIELD_NAME` VARCHAR(194) CHARACTER SET utf8 NOT NULL DEFAULT '',
`SCHEMA_NAME` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`DEFAULT_CHARACTER_SET_NAME` VARCHAR(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
`DEFAULT_COLLATION_NAME` VARCHAR(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
`SQL_PATH` VARCHAR(512) CHARACTER SET utf8 DEFAULT NULL,
`TABLE_CATALOG` VARCHAR(512) CHARACTER SET utf8 NOT NULL DEFAULT '',
`TABLE_SCHEMA` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`TABLE_TYPE` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`ENGINE` VARCHAR(64) CHARACTER SET utf8 DEFAULT NULL,
`VERSION` BIGINT(21) UNSIGNED DEFAULT NULL,
`ROW_FORMAT` VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL,
`TABLE_ROWS` BIGINT(21) UNSIGNED DEFAULT NULL,
`AVG_ROW_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`DATA_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`MAX_DATA_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`INDEX_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`DATA_FREE` BIGINT(21) UNSIGNED DEFAULT NULL,
`AUTO_INCREMENT` BIGINT(21) UNSIGNED DEFAULT NULL,
`CREATE_TIME` DATETIME DEFAULT NULL,
`UPDATE_TIME` DATETIME DEFAULT NULL,
`CHECK_TIME` DATETIME DEFAULT NULL,
`TABLE_COLLATION` VARCHAR(32) CHARACTER SET utf8 DEFAULT NULL,
`CHECKSUM` BIGINT(21) UNSIGNED DEFAULT NULL,
`CREATE_OPTIONS` VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL,
`TABLE_COMMENT` VARCHAR(2048) CHARACTER SET utf8 NOT NULL DEFAULT '',
`TABLE_NAME` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`COLUMN_NAME` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`ORDINAL_POSITION` BIGINT(21) UNSIGNED NOT NULL DEFAULT '0',
`COLUMN_DEFAULT` LONGTEXT CHARACTER SET utf8,
`IS_NULLABLE` VARCHAR(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
`DATA_TYPE` VARCHAR(64) CHARACTER SET utf8 NOT NULL DEFAULT '',
`CHARACTER_MAXIMUM_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`CHARACTER_OCTET_LENGTH` BIGINT(21) UNSIGNED DEFAULT NULL,
`NUMERIC_PRECISION` BIGINT(21) UNSIGNED DEFAULT NULL,
`NUMERIC_SCALE` BIGINT(21) UNSIGNED DEFAULT NULL,
`CHARACTER_SET_NAME` VARCHAR(32) CHARACTER SET utf8 DEFAULT NULL,
`COLLATION_NAME` VARCHAR(32) CHARACTER SET utf8 DEFAULT NULL,
`COLUMN_TYPE` LONGTEXT CHARACTER SET utf8 NOT NULL,
`COLUMN_KEY` VARCHAR(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
`EXTRA` VARCHAR(27) CHARACTER SET utf8 NOT NULL DEFAULT '',
`PRIVILEGES` VARCHAR(80) CHARACTER SET utf8 NOT NULL DEFAULT '',
`COLUMN_COMMENT` VARCHAR(1024) CHARACTER SET utf8 NOT NULL DEFAULT '',
PRIMARY KEY (`PROFILE_RECS_ID`)
) ENGINE=INNODB AUTO_INCREMENT=27399 DEFAULT CHARSET=latin1</pre>

&nbsp;

I think you could design a procedure(_returnExtents_) that would accept a schema_name, then loop through all tables and columns by selecting from the view or table we created earlier and store the results as follows

**Accept:** SCHEMA_NAME  
**Return:** max\_value, min\_value, num\_nulls, max\_length, min_length for each record in the above table. Or one record for each column in the schema.

Ideally you would write the results into a table as below

<pre>CREATE TABLE `mysql.profile_rec_extents` (
`PROF_VALUE_RECS_ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
`PROFILE_RECS_ID` BIGINT(20) DEFAULT NULL,
`MAX_VALUE` VARCHAR(250) DEFAULT NULL,
`MIN_VALUE` VARCHAR(250) DEFAULT NULL,
`NUM_NULLS` BIGINT(20) DEFAULT NULL,
`MAX_LENGTH_CHARS` BIGINT(20) DEFAULT NULL,
`MIN_LENGTH_CHARS` BIGINT(20) DEFAULT NULL,
`MAX_LENGTH_BYTES` BIGINT(20) DEFAULT NULL,
`MIN_LENGTH_BYTES` BIGINT(20) DEFAULT NULL,
PRIMARY KEY (`PROF_VALUE_RECS_ID`)
) ENGINE=INNODB</pre>

The following query returns somewhat useful information that could be used to populate the above table, but you&#8217;d have to loop it through every field.

<pre>SELECT MIN(FIELD_NAME) AS MIN_VALUE,
MAX(FIELD_NAME) AS MAX_VALUE,
MAX(CHAR_LENGTH(FIELD_NAME)) AS MAX_CHARS,
MIN(CHAR_LENGTH(FIELD_NAME)) AS MIN_CHARS,
MAX(LENGTH(FIELD_NAME)) AS MAX_BYTES,
MIN(LENGTH(FIELD_NAME)) AS MIN_BYTES
FROM profiler_recs;</pre>

Then, you do something like:

&nbsp;

<pre>for each VARCHAR field, where MAX_LENGTH &lt;= 25 do

SELECT
COUNT(*)
, `FIELDX`
FROM
`TABLEY`
GROUP BY `FIELDX`
ORDER BY COUNT(*) DESC;</pre>

&nbsp;

and load it into something like

<pre>CREATE TABLE `mysql.profile_value_recs` (
`PROF_DOMAIN_RECS_ID` BIGINT(20) NOT NULL AUTO_INCREMENT,
`PROFILE_RECS_ID` BIGINT(20) DEFAULT NULL,
`VALUE` VARCHAR(250) DEFAULT NULL,
`COUNT_VALUE` BIGINT(20) DEFAULT NULL,
`RUN_DATETIME` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`PROF_DOMAIN_RECS_ID`)) ENGINE=INNODB </pre>