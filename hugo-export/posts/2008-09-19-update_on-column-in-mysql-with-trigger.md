---
 #  UPDATE_ON column in MySQL with trigger
categories:
  - Uncategorized

---

DELIMITER $$

CREATE  
&nbsp;&nbsp;&nbsp; /\*[DEFINER = { user | CURRENT_USER }]\*/  
&nbsp;&nbsp;&nbsp; ON \`my\_database\`.\`my\_table\`  
&nbsp;&nbsp;&nbsp; FOR EACH ROW BEGIN  
&nbsp;&nbsp;&nbsp; END$$

DELIMITER ;