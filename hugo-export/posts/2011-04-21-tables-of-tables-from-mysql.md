---
title: Tables of Tables from MySQL
categories:
  - Database
  - Uncategorized

---
From Matthew Crowley on the MySQl forums (<a href="http://forums.mysql.com/read.php?101,8004" target="_blank">http://forums.mysql.com/read.php?101,8004</a>), this php script will output a DESC of all databases and tables in MySQL. It needs some formatting for the output, but it works and might be handy later. I really just need to get around to figuring out how to do this in a procedure or something.

[cce_php]

$connection = mysql_connect(&#8220;localhost&#8221;,&#8221;root&#8221;,&#8221;PASSWORD&#8221;);

$showDB = mysql_query(&#8220;show databases&#8221;);  
if($myrow=mysql\_fetch\_array($showDB))  
{  
do  
{  
$DB = $myrow[&#8220;Database&#8221;];  
echo &#8220;$DB \n&#8221;;  
$showTable = mysql_query(&#8220;show tables from $DB&#8221;);  
if($myrow=mysql\_fetch\_array($showTable))  
{  
do  
{  
$col = &#8220;Tables\_in\_&#8221;.$DB;  
$Table = $myrow[&#8220;$col&#8221;];  
echo &#8220;$Table \n&#8221;;  
$describeTable = mysql_query(&#8220;describe $DB.$Table&#8221;);  
if($myrow=mysql\_fetch\_array($describeTable))  
{  
do  
{  
$field = $myrow[&#8220;Field&#8221;];  
$null = $myrow[&#8220;Null&#8221;];  
$key = $myrow[&#8220;Key&#8221;];  
$default = $myrow[&#8220;Default&#8221;];  
$extra = $myrow[&#8220;Extra&#8221;];  
}  
while ($myrow=mysql\_fetch\_array($describeTable));  
}  
}  
while ($myrow=mysql\_fetch\_array($showTable));  
}  
}  
while ($myrow=mysql\_fetch\_array($showDB));  
}

[/cce_php]

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" src="http://img.zemanta.com/pixy.gif?x-id=adc45109-061d-89ca-8703-2cb25695bc7c" alt="" />
</div>