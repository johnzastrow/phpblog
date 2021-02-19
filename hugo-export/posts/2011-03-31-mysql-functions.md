---
title: MySQL Functions
author: John C. Zastrow
type: post
date: 2011-03-31T18:48:01+00:00
url: /2011/03/31/mysql-functions/
categories:
  - Database
  - Uncategorized

---
I just want to record these for future reference. I&#8217;m actually using the first now.

From the MySQL 5.0 Online manual

An example of how to make the first letter in a string uppercase &#8211; analogous to UCFIRST

[cce_sql]

SELECT CONCAT(UPPER(SUBSTRING(firstName, 1, 1)), LOWER(SUBSTRING(firstName FROM 2))) AS properFirstName

[/cce_sql]

a user-defined function in MySQL 5.0+ similar to PHP&#8217;s substr_count(), since I could not find an equivalent native function in MySQL. (If there is one please tell me!!!)

[cce_sql]

delimiter ||  
DROP FUNCTION IF EXISTS substrCount||  
CREATE FUNCTION substrCount(s VARCHAR(255), ss VARCHAR(255)) RETURNS TINYINT(3) UNSIGNED LANGUAGE SQL NOT DETERMINISTIC READS SQL DATA  
BEGIN  
DECLARE count TINYINT(3) UNSIGNED;  
DECLARE offset TINYINT(3) UNSIGNED;  
DECLARE CONTINUE HANDLER FOR SQLSTATE &#8216;02000&#8217; SET s = NULL;

SET count = 0;  
SET offset = 1;

REPEAT  
IF NOT ISNULL(s) AND offset > 0 THEN  
SET offset = LOCATE(ss, s, offset);  
IF offset > 0 THEN  
SET count = count + 1;  
SET offset = offset + 1;  
END IF;  
END IF;  
UNTIL ISNULL(s) OR offset = 0 END REPEAT;

RETURN count;  
END;

||

delimiter ;

[/cce_sql]

Use like this:

[cce_sql]

SELECT substrCount(&#8216;/this/is/a/path&#8217;, &#8216;/&#8217;) \`count\`;

[/cce_sql]

\`count\` would return 4 in this case. Can be used in such cases where you might want to find the &#8220;depth&#8221; of a path, or for many other uses.

It&#8217;s pretty easy to create your own string functions for many examples listed here

[cce_sql]  
\## Count substrings

CREATE FUNCTION substrCount(x varchar(255), delim varchar(12)) returns int  
return (length(x)-length(REPLACE(x, delim, &#8221;)))/length(delim);

SELECT substrCount(&#8216;/this/is/a/path&#8217;, &#8216;/&#8217;) as count;

[/cce_sql]

+&#8212;&#8212;-+  
| count |  
+&#8212;&#8212;-+  
|     4 |  
+&#8212;&#8212;-+

[cce_sql]

SELECT substrCount(&#8216;/this/is/a/path&#8217;, &#8216;is&#8217;) as count;

[/cce_sql]

+&#8212;&#8212;-+  
| count |  
+&#8212;&#8212;-+  
|     2 |  
+&#8212;&#8212;-+

[cce_sql]

\## Split delimited strings

CREATE FUNCTION strSplit(x varchar(255), delim varchar(12), pos int) returns varchar(255)  
return replace(substring(substring\_index(x, delim, pos), length(substring\_index(x, delim, pos &#8211; 1)) + 1), delim, &#8221;);

select strSplit(&#8220;aaa,b,cc,d&#8221;, &#8216;,&#8217;, 2) as second;

[/cce_sql]

+&#8212;&#8212;&#8211;+  
| second |  
+&#8212;&#8212;&#8211;+  
| b      |  
+&#8212;&#8212;&#8211;+

[cce_sql]

select strSplit(&#8220;a|bb|ccc|dd&#8221;, &#8216;|&#8217;, 3) as third;

[/cce_sql]

+&#8212;&#8212;-+  
| third |  
+&#8212;&#8212;-+  
| ccc   |  
+&#8212;&#8212;-+

[cce_sql]

select strSplit(&#8220;aaa,b,cc,d&#8221;, &#8216;,&#8217;, 7) as 7th;

[/cce_sql]

+&#8212;&#8212;+  
| 7th  |  
+&#8212;&#8212;+  
| NULL |  
+&#8212;&#8212;+

[cce_sql]

\## Upper case first letter, UCFIRST or INITCAP

CREATE FUNCTION ucfirst(x varchar(255)) returns varchar(255)  
return concat( upper(substring(x,1,1)),lower(substring(x,2)) );

select ucfirst(&#8220;TEST&#8221;);

[/cce_sql]

+&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;+  
| ucfirst(&#8220;TEST&#8221;) |  
+&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;+  
| Test            |  
+&#8212;&#8212;&#8212;&#8212;&#8212;&#8211;+

[cce_sql]

##Or a more complicated example, this will repeat an insert after every nth position.

drop function insert2;  
DELIMITER //  
CREATE FUNCTION insert2(str text, pos int, delimit varchar(124))  
RETURNS text  
DETERMINISTIC  
BEGIN  
DECLARE i INT DEFAULT 1;  
DECLARE str_len INT;  
DECLARE out_str text default &#8221;;  
SET str_len=length(str);  
WHILE(i<str_len) DO  
SET out\_str=CONCAT(out\_str, SUBSTR(str, i,pos), delimit);  
SET i=i+pos;  
END WHILE;  
&#8212; trim delimiter from end of string  
SET out\_str=TRIM(trailing delimit from out\_str);  
RETURN(out_str);  
END//  
DELIMITER ;

select insert2(&#8220;ATGCATACAGTTATTTGA&#8221;, 3, &#8221; &#8220;) as seq2;

[/cce_sql]

+&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-+  
| seq2                    |  
+&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-+  
| ATG CAT ACA GTT ATT TGA |  
+&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-+

&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;&#8212;-

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=26bdc108-b3ac-8690-b831-825b794bbe96" alt="" />
</div>