---
categories:
  - Database

---


Then I ran the query below to convert the numbers.

UPDATE Itec_data1  
SET [NEWDATE] = format(DateSerial (left([DATEOLD],4), mid([DATEOLD],5,2), right([DATEOLD],2)),&#8221;yyyy/mm/dd&#8221;);


UPDATE Itec_data1  
SET [DATETIMER] = [DATE]+[TIME];