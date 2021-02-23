---
 #  Loading tab-delimited data to local MySQL
categories:
  - Uncategorized

---
I&#8217;m looking at some data from the Avian Knowledge Network and Microsoft Access just isn&#8217;t up to dealing with the volume of records. So I switched over to MySQL.

I&#8217;m using the Positive Observation Essentials format as queried from their database. Here&#8217;s an example of the data:<img loading="lazy" style="max-width: 800px;" src="http://northredoubt.com/n/wp-content/uploads/2011/03/data_example.png" height="39" width="926" /> 

I did use a sed command (created and verified in Excel) on the original files to fix the spaces in the column names (if you are in the business of making data for people, never, ever, ever, ever create large tabular files with spaces or special characters in the column names. Avoid dashes as well, and preferably use all caps). Note that the commands below will REPLACE your files. So be sure to back up your originals in case anything goes wrong.

find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Record\ Number/Record_Number/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Global\ Unique\ Identifier/Global\_Unique\_Identifier/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Collection\ Code/Collection_Code/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Scientific\ Name/Scientific_Name/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Latitude/Latitude/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Longitude/Longitude/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Country/Country/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/State\ Province/State_Province/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Observation\ Count/Observation_Count/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Obs\ Count\ At\ Least/Obs\_Count\_At_Least/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Obs\ Count\ At\ Most/Obs\_Count\_At_Most/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Observation\ Date/Observation_Date/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Duration\ In\ Hours/Duration\_In\_Hours/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Time\ Observations\ Started/Time\_Observations\_Started/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Time\ Observations\ Ended/Time\_Observations\_Ended/g&#8217; {} \;  
find . -name &#8216;\*AKN\*&#8217; -exec sed -i &#8216;s/Sampling\ Event\ Identifier/Sampling\_Event\_Identifier/g&#8217; {} \;

Then I create a basic staging table (commands also from Excel). I don&#8217;t know why I used InnoDB, when MyIsam would have been faster. But, notice the absence of indexes for faster loading.

CREATE TABLE \`nv_akn\` (  
&nbsp; \`Record_Number\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Global\_Unique\_Identifier\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Collection_Code\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Scientific_Name\` VARCHAR(150) DEFAULT NULL,  
&nbsp; \`Latitude\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Longitude\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Country\` VARCHAR(50) DEFAULT NULL,  
&nbsp; \`State_Province\` VARCHAR(50) DEFAULT NULL,  
&nbsp; \`Observation_Count\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Obs\_Count\_At_Least\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Obs\_Count\_At_Most\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Observation_Date\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Duration\_In\_Hours\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Time\_Observations\_Started\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Time\_Observations\_Ended\` VARCHAR(30) DEFAULT NULL,  
&nbsp; \`Sampling\_Event\_Identifier\` VARCHAR(50) DEFAULT NULL  
) ENGINE=INNODB DEFAULT CHARSET=latin1

I&#8217;m just doing this locally, so XAMPP is my friend. So from the xampp /mysql/bin directory, I ran mysql.exe. I chose my database and ran the following on the text files produced by the above sed cleaners.

mysql> LOAD DATA LOCAL INFILE &#8216;c:/xampp/mysql/bin/Nevada\_Pos\_obs\_Essent\_15-MAR-2011.txt&#8217; INTO TABLE nv_akn  
FIELDS TERMINATED BY &#8216;\t&#8217;  
LINES TERMINATED BY &#8216;\n&#8217; IGNORE 1 LINES;

I used LOCAL since the database is on my workstation. Note the full path to the windows file, with forward slashes. Fields are tab-delimited, lines seem to just use carriage returns (or at least it doesn&#8217;t look like I need another line ender) and I&#8217;m ignoring the column header row.

<div class="zemanta-pixie">
  <img class="zemanta-pixie-img" alt="" src="http://img.zemanta.com/pixy.gif?x-id=f9368272-1492-847d-9091-49726d62d833" />
</div>