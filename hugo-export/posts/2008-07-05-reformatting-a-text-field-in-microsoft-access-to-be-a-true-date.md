---
title: Reformatting a text field in Microsoft Access to be a true date
author: John C. Zastrow
type: post
date: 2008-07-06T01:24:22+00:00
url: /2008/07/05/reformatting-a-text-field-in-microsoft-access-to-be-a-true-date/
categories:
  - Database

---
I had a text field (DATEOLD) with values like 20030526, that were dates in YYYYMMDD. 

I needed these values to exist in a true datetime field in Microsoft  
Access. So I created a new field called NEWDATE of the date/time type. 

Then I ran the query below to convert the numbers.

UPDATE Itec_data1  
SET [NEWDATE] = format(DateSerial (left([DATEOLD],4), mid([DATEOLD],5,2), right([DATEOLD],2)),&#8221;yyyy/mm/dd&#8221;);

Because dates and times are stored as integers and decimals  
respectively, with two datetime fields (DATE and TIME) you can create a  
third and final datetime field (DATETIMER) simply by adding them.

UPDATE Itec_data1  
SET [DATETIMER] = [DATE]+[TIME];