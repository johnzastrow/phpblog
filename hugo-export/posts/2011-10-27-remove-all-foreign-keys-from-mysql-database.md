---
title: Remove all foreign keys from MySQL database
categories:
  - Data processing
  - Database

---
I needed to load some lookup data into a MySQL database littered with foreign keys. So I copied the empty DB and ran the output of the following:  
[cc lang=&#8217;sql&#8217; ]  
SELECT CONCAT(&#8216;alter table &#8216;,table\_schema,&#8217;.&#8217;,table\_name,&#8217; DROP FOREIGN KEY &#8216;,constraint_name,&#8217;;&#8217;)  
FROM information\_schema.table\_constraints  

I loaded the values, and dumped just the values (only insert statements) that I will use to populate the version of the DB with my FK&#8217;s intact.

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=c91d2d8b-38fd-85cf-a328-4abe703f51cf" />
</div>