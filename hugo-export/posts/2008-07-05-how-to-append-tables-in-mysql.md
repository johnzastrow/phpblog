---
title: How to append tables in Mysql
categories:
  - Database

---
For those of you that have puzzled over how to append tables in Mysql like an Access &#8216;Append&#8217; query, start here:

<pre>insert into table1 select * from table2;&lt;br /&gt;</pre>

Where table1 and table2 are identical. This might fail if you use an auto-incrementing counter on both.