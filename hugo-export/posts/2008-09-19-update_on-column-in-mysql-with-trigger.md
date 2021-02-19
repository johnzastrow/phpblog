---
title: UPDATE_ON column in MySQL with trigger
author: John C. Zastrow
type: post
date: 2008-09-19T20:23:31+00:00
url: /2008/09/19/update_on-column-in-mysql-with-trigger/
categories:
  - Uncategorized

---
I needed to update a column with the date and time whenever a record changed in my database. So here is the recipe for the trigger in MySQL 5.0.

DELIMITER $$

CREATE  
&nbsp;&nbsp;&nbsp; /\*[DEFINER = { user | CURRENT_USER }]\*/  
&nbsp;&nbsp;&nbsp; TRIGGER \`my_database\`.\`UpdatedOn\` BEFORE UPDATE  
&nbsp;&nbsp;&nbsp; ON \`my\_database\`.\`my\_table\`  
&nbsp;&nbsp;&nbsp; FOR EACH ROW BEGIN  
set NEW.update_on = now();  
&nbsp;&nbsp;&nbsp; END$$

DELIMITER ;