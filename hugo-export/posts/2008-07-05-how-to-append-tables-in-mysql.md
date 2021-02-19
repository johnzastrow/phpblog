---
title: How to append tables in Mysql
author: John C. Zastrow
type: post
date: 2008-07-05T23:58:01+00:00
url: /2008/07/05/how-to-append-tables-in-mysql/
categories:
  - Database

---
For those of you that have puzzled over how to append tables in Mysql like an Access &#8216;Append&#8217; query, start here:

<pre>insert into table1 select * from table2;&lt;br /&gt;</pre>

Where table1 and table2 are identical. This might fail if you use an auto-incrementing counter on both.